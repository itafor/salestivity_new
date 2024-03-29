<?php

namespace App\Http\Controllers;

use App\CarbonCopyEmail;
use App\Category;
use App\CompanyAccountDetail;
use App\CurrencySymbol;
use App\Customer;
use App\Http\Services\Billing\BillingInvoiceServices;
use App\Http\Traits\InvoiceBillStatus;
use App\Invoice;
use App\InvoiceContact;
use App\InvoicePayment;
use App\Mail\InvoicePaid;
use App\Mail\SendInvoice;
use App\Product;
use App\ReplyToEmail;
use App\SubCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class InvoiceController extends Controller
{
    use InvoiceBillStatus;
    public $billing_invoice;

    public function __construct(BillingInvoiceServices $billinginvoice)
    {
        $this->middleware(['auth', 'mainuserVerified', 'subuserVerified'])->except(['homepage', 'verifySubuserEmail', 'confirmInvoiceReceipt']);
        $this->billing_invoice = $billinginvoice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['invoices'] = Invoice::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', '!=', 'Paid'],
        ])->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();

        return view('billing.invoice.index', $data);
    }

    public function getBillingInvoices($id)
    {
        switch ($id) {
            case 'all':
                $data['invoices'] = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                ])->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();

                return view('billing.invoice.all', $data);
                break;

            case 'paid':
                $data['invoices'] = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', 'Paid'],
                ])->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();

                return view('billing.invoice.paid', $data);
                break;

            case 'pending':
                $data['invoices'] = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', 'Pending'],
                ])->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();

                return view('billing.invoice.pending', $data);
                break;

            case 'outstanding':
                $data['invoices'] = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', '!=', 'Paid'],
                ])->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();

                return view('billing.invoice.outstanding', $data);
                break;

            case 'partly_paid':
                $data['invoices'] = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', 'Partly Paid'],
                ])->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();

                return view('billing.invoice.partly_paid', $data);
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $data['currencies'] = CurrencySymbol::all();
        $data['customers'] = Customer::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['categories'] = Category::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        // $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['mail_from_name'] = User::where([
            ['id', getActiveGuardType()->main_acct_id],
        ])->first();

        $data['reply_to_emails'] = ReplyToEmail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['cc_emails'] = CarbonCopyEmail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        return view('billing.invoice.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guard_object = \getActiveGuardType();
        $input = $request->all();

        $contactEmails = isset($input['contact_emails']) ? $input['contact_emails'] : '';

        // dd($input);
        $rules = [

            'customer' => 'required',
            // 'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required',
            // 'category_id' => 'required',
            // 'sub_category_id' => 'required',
            'company_bank_acc_id' => 'required',
            'due_date' => 'required',
            'currency_id' => 'required',
            'reply_to_email_id' => 'required',
            'cc_email_id' => 'required',
            'mail_from_name' => 'required',

        ];
        $message = [
            'customer.required' => 'Customer name is required',
            'product.required' => 'Please choose a Product',
            'timeline.required' => 'Please pick a timeline',
            'cost.required' => 'Please input cost',
            'category_id.required' => 'Product category is required',
            'sub_category_id.required' => 'Product subcategory is required',
            'company_bank_acc_id.required' => 'company bank account is required',
            'due_date.required' => 'Due date is required',
            'payment_due.required' => 'Payment Due is required',
            'term_condition.required' => 'Term and condition is required',
            'currency_id.required' => 'Currency is required',
            'mail_from_name.required' => 'Mail From Name is required',
            'reply_to_email_id.required' => 'ReplyToEmail is required',
            'cc_email_id.required' => 'CC email is required',

        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $finalPrice = getFinalPrice($input['discount'], $input['cost'], $input['value_added_tax'], $input['withholding_tax']);

        $invoice = new Invoice;
        $invoice->created_by = $guard_object->created_by;
        $invoice->user_type = $guard_object->user_type;
        $invoice->main_acct_id = $guard_object->main_acct_id;
        $invoice->customer = $request->customer;
        $invoice->category_id = $request->category_id;
        $invoice->subcategory_id = $request->sub_category_id;
        $invoice->product_id = $request->product;
        $invoice->timeline = $request->timeline;
        $invoice->cost = $request->cost;
        $invoice->discount = $request->discount;
        $invoice->status = 'Pending';
        $invoice->billingAmount = $finalPrice;
        $invoice->billingBalance = $finalPrice;

        $invoice->company_bank_acc_id = $request->company_bank_acc_id;
        $invoice->due_date = Carbon::parse(formatDate($request->due_date, 'd/m/Y', 'Y-m-d'));
        $invoice->invoice_number = 'DW' . mt_rand(1000, 9999);
        $invoice->payment_due = $request->payment_due;
        $invoice->term_condition = $request->term_condition;
        $invoice->currency_id = $request->currency_id;
        $invoice->mail_from_name = $request->mail_from_name;
        $invoice->reply_to_email_id = $request->reply_to_email_id;
        $invoice->cc_email_id = $request->cc_email_id;
        $invoice->value_added_tax = $request->value_added_tax;
        $invoice->withholding_tax = $request->withholding_tax;
        $invoice->save();

        if ($invoice) {

            $this->billing_invoice->storeInvoiceProducts($input, $invoice);

            self::createInvoiceContactEmail($invoice, $contactEmails);

            $contactEmails = [];

            $contactEmails[] = getUserCCEmailAddress($invoice);
            // dd($invoice->contacts);
            if ($invoice->contacts != null) {
                foreach ($invoice->contacts as $key => $contact) {
                    if ($contact->contact_id != null) {
                        $contactEmails[] = $contact->user->email;
                    }
                }
            }

            $toEmail = $invoice->customers->email;

            Mail::to($toEmail)->queue(new SendInvoice($invoice, $contactEmails));

            self::update_invoice_bill_status_to_sent($invoice);

            $status = "New Invoice has been Added ";
            Alert::success('Invoice', $status);

            return redirect()->route('billing.invoice.index');
        }

        Alert::error('Invoice', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }

    public static function createInvoiceContactEmail($invoice, $contactEmails)
    {

        if ($contactEmails != '') {
            foreach ($contactEmails as $key => $contactEmail) {
                $invoiceContact = new InvoiceContact();
                $invoiceContact->contact_id = isset($contactEmail['contact_id']) ? $contactEmail['contact_id'] : $contactEmail;
                $invoiceContact->invoice_id = $invoice->id;
                $invoiceContact->save();
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id, $status, $navStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id, $status, $navStatus)
    {
        $invoice = Invoice::find($id);
        $customers = Customer::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $products = Product::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $invoice_products = $invoice->invoiceProducts;

        $maxId = 0;
        $minId = 0;
        $currentId = $id;

        return view('billing.invoice.show', compact('invoice', 'maxId', 'minId', 'currentId', 'invoice_products'));
    }

    /**
     * Navigate from one invoice to another
     * @param mixed $id
     * @param mixed $status
     * @param mixed $navStatus
     *
     * @return \Illuminate\Http\Response
     */
    public function navigateInvoices($id, $status, $navStatus)
    {
        $invoice = Invoice::find($id);
        $customers = Customer::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $products = Product::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $maxId = 0;
        $minId = 0;
        $currentId = $id;
        if ($status == "partly_paid" && $navStatus == "next") {
            $maxId = $this->getPaidPartlyPaidPendingInvoiceMaxId('Partly paid');
            $invoice = Invoice::where([
                $maxId == $id ? ['id', '>=', $id] : ['id', '>', $id],
                ['status', 'Partly paid'],
                ['main_acct_id', getActiveGuardType()->main_acct_id],
            ])->orderBy('id', 'asc')->with(['customers', 'prod'])->first();
        } elseif ($status == "outstanding" && $navStatus == "next") {
            $maxId = $this->getPaidPartlyPaidPendingInvoiceMaxId('Pending');
            $invoice = Invoice::where([
                $maxId == $id ? ['id', '>=', $id] : ['id', '>', $id],
                ['status', 'Pending'],
                ['main_acct_id', getActiveGuardType()->main_acct_id],
            ])->orderBy('id', 'asc')->with(['customers', 'prod'])->first();
        } elseif ($status == "paid" && $navStatus == "next") {
            $maxId = $this->getPaidPartlyPaidPendingInvoiceMaxId('paid');
            $invoice = Invoice::where([
                $maxId == $id ? ['id', '>=', $id] : ['id', '>', $id],
                ['status', 'Paid'],

                ['main_acct_id', getActiveGuardType()->main_acct_id],
            ])->orderBy('id', 'asc')->with(['customers', 'prod'])->first();
        } elseif ($status == "partly_paid" && $navStatus == "previous") {
            $minId = $this->getPaidPartlyPaidPendingInvoiceMinId('Partly paid');
            $invoice = Invoice::where([
                $minId == $id ? ['id', '<=', $id] : ['id', '<', $id],
                ['status', 'Partly paid'],
                ['main_acct_id', getActiveGuardType()->main_acct_id],
            ])->orderBy('id', 'desc')->with(['customers', 'prod'])->first();
        } elseif ($status == "outstanding" && $navStatus == "previous") {
            $minId = $this->getPaidPartlyPaidPendingInvoiceMinId('Pending');
            $invoice = Invoice::where([
                $minId == $id ? ['id', '<=', $id] : ['id', '<', $id],
                ['status', 'Pending'],
                ['main_acct_id', getActiveGuardType()->main_acct_id],
            ])->orderBy('id', 'desc')->with(['customers', 'prod'])->first();
        } elseif ($status == "paid" && $navStatus == "previous") {
            $minId = $this->getPaidPartlyPaidPendingInvoiceMinId('Paid');
            $invoice = Invoice::where([
                $minId == $id ? ['id', '<=', $id] : ['id', '<', $id],
                ['status', 'Paid'],
                ['main_acct_id', getActiveGuardType()->main_acct_id],
            ])->orderBy('id', 'desc')->with(['customers', 'prod'])->first();
        }

        return view('billing.invoice.show', compact('invoice', 'maxId', 'minId', 'currentId'));
    }

    /**
     * Get paid, partly paid and pending invoice with the highest id
     * @param mixed $status
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaidPartlyPaidPendingInvoiceMaxId($status)
    {
        return Invoice::where([
            ['status', $status],
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->max('id');
    }

    /**
     * Get paid, partly paid and pending invoice with the lowest id
     * @param mixed $status
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaidPartlyPaidPendingInvoiceMinId($status)
    {
        return Invoice::where([
            ['status', $status],
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->min('id');
    }

    public function pay(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'productPrice' => 'required|numeric',
            'billingAmount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'billingbalance' => 'required',
            'customer_id' => 'required|numeric',
            // 'product_id' => 'required|numeric',
            'invoice_id' => 'required|numeric',
            'payment_date' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        DB::beginTransaction();
        try {
            $paid_invoice = InvoicePayment::createNew($request->all());
            // dd($paid_invoice);
            $toEmail = $paid_invoice->customer->email;
            if ($toEmail) {
                Mail::to($toEmail)->queue(new InvoicePaid($paid_invoice));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            Alert::error('Invoice Payment', 'An attempt to record invoice payment failed');
            return back()->withInput();
        }

        $paymentStatus = invoicePaymentStatus($paid_invoice->invoice);
        Alert::success('Invoice Payment', 'Invoice payment recorded successfully');
        return redirect()->route('billing.invoice.show', [$request->invoice_id, $paymentStatus, 'next']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $invoice = Invoice::find($id);
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $sub_categories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('billing.invoice.manage', compact('invoice', 'customers', 'products', 'categories', 'sub_categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['invoice'] = Invoice::find($id);

        $userId = \getActiveGuardType()->main_acct_id;
        $data['currencies'] = CurrencySymbol::all();
        $data['customers'] = Customer::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['categories'] = Category::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        // $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['mail_from_name'] = User::where([
            ['id', getActiveGuardType()->main_acct_id],
        ])->first();

        $data['reply_to_emails'] = ReplyToEmail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['cc_emails'] = CarbonCopyEmail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['invoice_products'] = $data['invoice']->invoiceProducts;

        return view('billing.invoice.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();

        $contactEmails = isset($input['contact_emails']) ? $input['contact_emails'] : '';

        // dd($input);
        $rules = [
            'invoice_id' => 'required',
            'customer' => 'required',
            // 'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required',
            // 'category_id' => 'required',
            // 'sub_category_id' => 'required',
            'due_date' => 'required',
            'company_bank_acc_id' => 'required',
        ];
        $message = [
            'customer.required' => 'Customer name is required',
            'product.required' => 'Please choose a Product',
            'timeline.required' => 'Please pick a timeline',
            'cost.required' => 'Please input cost',
            'category_id.required' => 'Product category is required',
            'sub_category_id.required' => 'Product subcategory is required',
            'invoice_id.required' => 'Invoice ID is required',
            'due_date.required' => 'Due Date is required',
            'company_bank_acc_id.required' => 'Company bank detail is required',
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $invoice = Invoice::find($input['invoice_id']);
        $original_billing_amount = $invoice->billingBalance + $invoice->amount_paid;
        $billing_bal = $request->billingAmount - $original_billing_amount;
        // dd($billing_bal);

        $billing_bal = $billing_bal + $invoice->billingBalance;
        // dd($billing_bal);
        $invoice->customer = $input['customer'];
        $invoice->timeline = $input['timeline'];
        $invoice->cost = $input['cost'];
        $invoice->discount = isset($input['discount']) ? $input['discount'] : null;
        $invoice->billingAmount = $request->billingAmount;
        $invoice->billingBalance = $billing_bal;
        $invoice->company_bank_acc_id = $input['company_bank_acc_id'];
        $invoice->due_date = Carbon::parse(formatDate($input['due_date'], 'd/m/Y', 'Y-m-d'));
        $invoice->payment_due = $request->payment_due;
        $invoice->term_condition = $request->term_condition;
        $invoice->currency_id = $request->currency_id;
        $invoice->mail_from_name = $request->mail_from_name;
        $invoice->reply_to_email_id = $request->reply_to_email_id;
        $invoice->cc_email_id = $request->cc_email_id;
        $invoice->value_added_tax = $request->value_added_tax;
        $invoice->withholding_tax = $request->withholding_tax;
        $invoice->save();
        if ($invoice) {

            $this->billing_invoice->updateInvoiceProducts($input, $invoice);

           $this->updateInvoiceContactEmail($input, $contactEmails);

             $contactEmails = [];

            $contactEmails[] = getUserCCEmailAddress($invoice);
            // dd($invoice->contacts);
            if ($invoice->contacts != null) {
                foreach ($invoice->contacts as $key => $contact) {
                    if ($contact->contact_id != null) {
                        $contactEmails[] = $contact->user->email;
                    }
                }
            }

            $toEmail = $invoice->customers->email;

            Mail::to($toEmail)->queue(new SendInvoice($invoice, $contactEmails));

            $status = "Invoice has been been updated";
            Alert::success('Invoice', $status);
            return back()->withInput()->withSuccess($status);

            // return redirect()->route('billing.invoice.show', $invoice->id);
        }

        Alert::error('Invoice', 'The action could not be completed');
        return back()->withInput()->withErrors($validator);
    }

      public function updateInvoiceContactEmail($data, $contactEmails) {

        $invoiceContact = InvoiceContact::where('invoice_id', $data['invoice_id'])->get();
        if(count($invoiceContact) >= 1){
            foreach ($invoiceContact as $key => $contactEmail) {
                $contactEmail->delete();
            }
        }
   
    if($contactEmails !='' && $contactEmails[0] != null){
    foreach ($contactEmails as $key => $contactEmail) {
       $invoiceContact = new InvoiceContact();
       $invoiceContact->contact_id = $contactEmail;
       $invoiceContact->invoice_id = $data['invoice_id'];
       $invoiceContact->save();
    }

  }

 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        // $payment = Payment::where
        $invoice->delete();

        Session::flash('status', 'The Invoice has been successfully deleted');
        return redirect()->route('billing.invoice.index');
    }

    public function downloadInvoicePayment($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        $pdf = PDF::loadView('emails.sendinvoice', [
            'invoice' => $invoice,
        ]);

        $documentName = 'invoicePayment_' . $invoice->invoice_number . '.pdf';

        return $pdf->download($documentName);
    }

    public function resendInvoicePayment($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        $toEmail = $invoice->customers->email;

        $invoiceResent = Mail::to($toEmail)->queue(new SendInvoice($invoice));

        self::update_invoice_bill_status_to_sent($invoice);

        $status = "Invoice has been resent successfully";
        Alert::success('Invoice Resent', $status);
        return back();
    }

    public static function update_invoice_bill_status_to_sent($invoice)
    {
        $invoice = Invoice::find($invoice->id);
        $invoice->bill_status = 'Sent';
        $invoice->save();
    }

    public function resendInvoicePaymentReceipt($invoice_payment_id)
    {
        $paid_invoice = InvoicePayment::where('id', $invoice_payment_id)->first();

        $toEmail = $paid_invoice->customer->email;
        if ($toEmail) {
            Mail::to($toEmail)->queue(new InvoicePaid($paid_invoice));
        }

        Alert::success('Resend Invoice Payment', 'Invoice payment receipt resent.');
        return back(); // redirect()->route('billing.renewal.show',$renewal_payment->renewal->id);
    }

    public function downloadInvoicePaymentReceipt($invoice_payment_id)
    {
        $paid_invoice = InvoicePayment::where('id', $invoice_payment_id)->first();
        if ($paid_invoice) {
            $pdf = PDF::loadView('emails.invoicePaid', [
                'paid_invoice' => $paid_invoice,
            ]);

            dd($paid_invoice);

            $documentName = 'paymentConfirmation_' . $paid_invoice->id . '.pdf';

            return $pdf->download($documentName);
        }
    }

    public function filterInvoiceBystartEndDate(Request $request)
    {
        $validator = $request->validate([
            "start_date" => "required|string",
            "end_date" => "required|string",
            "status" => "required|string",
        ]);

        $startDate = $validator['start_date'];
        $endDate = $validator['end_date'];
        $status = $validator['status'];

        $start_date = Carbon::parse(formatDate($validator['start_date'], 'd/m/Y', 'Y-m-d'));
        $end_date = Carbon::parse(formatDate($validator['end_date'], 'd/m/Y', 'Y-m-d'));
        // dd($validator);

        switch ($status) {
            case 'all':

                $invoices = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                ])
                    ->whereBetween('due_date', [$start_date, $end_date])
                    ->orderBy('created_at', 'asc')->with(['customers', 'prod'])->get();

                return view('billing.invoice.all', compact('invoices', 'startDate', 'endDate'));
                break;

            case 'paid':

                $invoices = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', 'Paid'],
                ])
                    ->whereBetween('due_date', [$start_date, $end_date])
                    ->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();
                return view('billing.invoice.paid', compact('invoices', 'startDate', 'endDate'));
                break;

            case 'pending':
                $invoices = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', 'Pending'],
                ])
                    ->whereBetween('due_date', [$start_date, $end_date])
                    ->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();
                return view('billing.invoice.pending', compact('invoices', 'startDate', 'endDate'));
                break;

            case 'outstanding':

                $invoices = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', '!=', 'Paid'],
                ])
                    ->whereBetween('due_date', [$start_date, $end_date])
                    ->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();
                return view('billing.invoice.outstanding', compact('invoices', 'startDate', 'endDate'));
                break;

            case 'partly_paid':

                $invoices = Invoice::where([
                    ['main_acct_id', getActiveGuardType()->main_acct_id],
                    ['status', 'Partly Paid'],
                ])
                    ->whereBetween('due_date', [$start_date, $end_date])
                    ->orderBy('due_date', 'asc')->with(['customers', 'prod'])->get();
                return view('billing.invoice.partly_paid', compact('invoices', 'startDate', 'endDate'));
                break;

            default:
                # code...
                break;
        }
    }

}
