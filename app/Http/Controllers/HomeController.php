<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Opportunity;
use App\Renewal;
use App\SubUser;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except(['homepage','displayNonHttpErrors']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        if(authUser()){
            return redirect()->route('home');
        }
        return view('welcome');
    }

     /**
     * Display non http errors on page.
     *
     * @return \Illuminate\View\View
     */
    public function displayNonHttpErrors()
    {
        return view('errors.NonHttpErrors');
    }

     

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
             $userId = auth()->user()->id;
        $today = Carbon::now();
       $data['current_month'] = $today->format('M');
       $data['formated_current_yr'] = $today->format('Y');
        $guard_object = getActiveGuardType();
        $curr_year = Carbon::now('y');
        $curr_momth = Carbon::now('m');
        // dd($curr_momth);
        // if($guard_object->user_type == 'users'){
            // this array holds the ids of subusers that report to parent  user
             $parentUserAndSubUsersThatReportToThem = array('0'=>[0]);

            $get_main_user_from_subuser = SubUser::where('email',authUser()->email)->first();

             $usersThatreportsToParentUser = $get_main_user_from_subuser == '' ? [] : $get_main_user_from_subuser->users_that_report_tome->pluck('id')->toArray();

             $arrayLenght = count($usersThatreportsToParentUser);
             $i = 0;

             while ( $i <  $arrayLenght) {
                
                 $subUser = SubUser::where('id', $usersThatreportsToParentUser[$i])->first();
                    $subusersThatreportToThisSubUser = $subUser->users_that_report_tome->pluck('id')->toArray();
                    if($subusersThatreportToThisSubUser){
                    $parentUserAndSubUsersThatReportToThem[] = $subusersThatreportToThisSubUser;
                    }

                $i++;
             }
                //combine a multidimensional array to one single array
             $combinedArray = call_user_func_array('array_merge', $parentUserAndSubUsersThatReportToThem);

             $idsOfUsersUnderParentUser =   array_merge($combinedArray, $usersThatreportsToParentUser);
// ....................Last month Open opportunities...........................................
               $parent_user_last_month_opportunities = Opportunity::where([
                ['created_by', getActiveGuardType()->created_by],
                ['user_type', getActiveGuardType()->user_type],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_last_month_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

              $last_month_opportunities = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities);

             $last_month_opportunities_amt_sum = $parent_user_last_month_opportunities->merge($users_that_reports_to_parent_user_last_month_opportunities)->sum('amount');

            $data['last_month_opportunities_count'] = count($last_month_opportunities); 
            $data['last_month_opportunities_amt_sum'] = $last_month_opportunities_amt_sum;
// .............................Current Month Open Opportunities.............................................

             $parent_user_current_month_opportunities = Opportunity::where([
                ['created_by', getActiveGuardType()->created_by],
                ['user_type', getActiveGuardType()->user_type],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_current_month_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $current_month_opportunities = $parent_user_current_month_opportunities->merge($users_that_reports_to_parent_user_current_month_opportunities);

            $current_month_opportunities_amt_sum = $parent_user_current_month_opportunities->merge($users_that_reports_to_parent_user_current_month_opportunities)->sum('amount');
            

            $data['current_month_opportunities_count'] = count($current_month_opportunities); 
            $data['current_month_opportunities_amt_sum'] = $current_month_opportunities_amt_sum;

            $data['last_month_plus_current_month_opp_count'] = count($current_month_opportunities) + count($last_month_opportunities);

            $data['last_month_plus_current_month_opp_amt_sum'] =  $last_month_opportunities_amt_sum + $current_month_opportunities_amt_sum;

            $opp_amt_difference = $data['last_month_opportunities_amt_sum'] == 0 ? 0 :  ($data['current_month_opportunities_amt_sum'] - $data['last_month_opportunities_amt_sum']) / abs($data['last_month_opportunities_amt_sum']);

            $data['opp_percentage_change'] =  $opp_amt_difference * 100;

            $data['formatted_opp_percentage_change'] = round($data['opp_percentage_change'], 2);
            //dd($data['last_month_opportunities_amt_sum']);
// ----------------------------------------Year To Date Open Opportunities----------------------------------------

             $parent_user_YTD_opportunities = Opportunity::where([
                ['created_by', getActiveGuardType()->created_by],
                ['user_type', getActiveGuardType()->user_type],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereYear('created_at', $curr_year)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_YTD_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', '!=', 'Closed Won'],
                ['status', '!=', 'Closed Lost'],
            ])->whereYear('created_at', $curr_year)->get();

        $ytd_opportunities = $parent_user_YTD_opportunities->merge($users_that_reports_to_parent_user_YTD_opportunities);
            

            $data['ytd_opportunities_amt_sum'] = $parent_user_YTD_opportunities->merge($users_that_reports_to_parent_user_YTD_opportunities)->sum('amount');
        $data['ytd_opp_count'] = count($ytd_opportunities);
        $data['total_open_opportunity_count'] =  count($last_month_opportunities) +  $data['ytd_opp_count'];
// ...........................................................................................





        // ....................Last month Won opportunities...........................................
               $parent_user_last_month_won_opportunities = Opportunity::where([
                ['created_by', getActiveGuardType()->created_by],
                ['user_type', getActiveGuardType()->user_type],
                ['status', 'Closed Won'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_last_month_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->get();//last month opp

              $last_month_won_opportunities = $parent_user_last_month_won_opportunities->merge($users_that_reports_to_parent_user_last_month_won_opportunities);

             $last_month_won_opportunities_amt_sum = $parent_user_last_month_won_opportunities->merge($users_that_reports_to_parent_user_last_month_won_opportunities)->sum('amount');

            $data['last_month_won_opportunities_count'] = count($last_month_won_opportunities); 
            $data['last_month_won_opportunities_amt_sum'] = $last_month_won_opportunities_amt_sum;
// .............................Current Month Won Opportunities.............................................

             $parent_user_current_month_won_opportunities = Opportunity::where([
                ['created_by', getActiveGuardType()->created_by],
                ['user_type', getActiveGuardType()->user_type],
                ['status', 'Closed Won'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_current_month_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereBetween('created_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();

            $current_month_won_opportunities = $parent_user_current_month_won_opportunities->merge($users_that_reports_to_parent_user_current_month_won_opportunities);

            $current_month_won_opportunities_amt_sum = $parent_user_current_month_won_opportunities->merge($users_that_reports_to_parent_user_current_month_won_opportunities)->sum('amount');
            

            $data['current_month_won_opportunities_count'] = count($current_month_won_opportunities); 
            $data['current_month_won_opportunities_amt_sum'] = $current_month_won_opportunities_amt_sum;

            $data['last_month_plus_current_month_won_opp_count'] = count($current_month_won_opportunities) + count($last_month_won_opportunities);

            $data['last_month_plus_current_month_won_opp_amt_sum'] =  $last_month_won_opportunities_amt_sum + $current_month_won_opportunities_amt_sum;

            $won_opp_amt_difference = $data['last_month_won_opportunities_amt_sum'] == 0 ? 0 :  ($data['current_month_won_opportunities_amt_sum'] - $data['last_month_won_opportunities_amt_sum']) / abs($data['last_month_won_opportunities_amt_sum']);

            $data['won_opp_percentage_change'] = round($won_opp_amt_difference * 100, 2);


               // dd($data['last_month_won_opportunities_amt_sum']);
// ----------------------------------------Year To Date Won Opportunities----------------------------------------

             $parent_user_YTD_won_opportunities = Opportunity::where([
                ['created_by', getActiveGuardType()->created_by],
                ['user_type', getActiveGuardType()->user_type],
                ['status', 'Closed Won'],
            ])->whereYear('created_at', $curr_year)->get();

             // fetch the opportunities of  subusers under parent users
            $users_that_reports_to_parent_user_YTD_won_opportunities = Opportunity::whereIn('created_by', $idsOfUsersUnderParentUser)->where([
                ['user_type', 'sub_users'],
                ['status', 'Closed Won'],
            ])->whereYear('created_at', $curr_year)->get();

        $ytd_won_opportunities = $parent_user_YTD_won_opportunities->merge($users_that_reports_to_parent_user_YTD_won_opportunities);
            

         $data['ytd_won_opportunities_amt_sum'] =  $ytd_won_opportunities->sum('amount');
        $data['ytd_won_opp_count'] = count($ytd_won_opportunities);

         $data['total_won_opportunity_count'] = count($last_month_won_opportunities) +  $data['ytd_won_opp_count'];

        // ......................Outstanding Renewal (Recurring) current mmonth......................
        // $current_month_partly_paid_renewal = Renewal::where([
        //     ['status', 'Partly paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();

        //  $current_month_pending_renewal = Renewal::where([
        //     ['status', 'Pending'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();
      

        //  $data['current_month_outstanding_renewal_amt'] = $current_month_partly_paid_renewal->sum('billingBalance') + $current_month_pending_renewal->sum('billingAmount');

        //   $data['current_month_outstanding_renewal_count'] = count($current_month_partly_paid_renewal->merge($current_month_pending_renewal));

           // ......................Outstanding Renewal (Recurring) year to date......................
        // $ytd_partly_paid_renewal = Renewal::where([
        //     ['status', 'Partly paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereYear('created_at', $curr_year)->get();

        //  $ytd_pending_renewal = Renewal::where([
        //     ['status', 'Pending'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereYear('created_at', $curr_year)->get();
      

        //  $data['ytd_outstanding_renewal_amt'] = $ytd_partly_paid_renewal->sum('billingBalance') + $ytd_pending_renewal->sum('billingAmount');

        //   $data['ytd__outstanding_renewal_count'] = count($ytd_partly_paid_renewal->merge($ytd_pending_renewal));

          // dd($data['ytd_outstanding_renewal_amt']);

        // ......................Paid Renewal (Recurring) current mmonth......................
        // $current_month_paid_renewal = Renewal::where([
        //     ['status', 'Paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();


        //  $data['current_month_paid_renewal_amt'] = $current_month_paid_renewal->sum('billingBalance');

        //   $data['current_month_outstanding_renewal_count'] = count($current_month_partly_paid_renewal->merge($current_month_pending_renewal));
       
         // ......................paid Renewal (Recurring) current mmonth......................
    //     $currentMonthpartially_paid_renewal = Renewal::where([
    //         ['status', 'Partly paid'],
    //        ['main_acct_id', getActiveGuardType()->main_acct_id]
    //     ])->whereMonth('created_at', $curr_momth)->get();

    //      $current_month_completely_paid_renewal = Renewal::where([
    //         ['status', 'Paid'],
    //        ['main_acct_id', getActiveGuardType()->main_acct_id]
    //     ])->whereMonth('created_at', $curr_momth)->get();
      

    //  $data['current_month_partially_paid_renewal_amt'] = $currentMonthpartially_paid_renewal->sum('billingAmount') - $currentMonthpartially_paid_renewal->sum('billingBalance');

    //  $data['current_month_completely_paid_renewal_amt'] = $current_month_completely_paid_renewal->sum('billingAmount'); 

    //  $data['paid_recurring_amount_for_current_month'] = $data['current_month_partially_paid_renewal_amt'] + $data['current_month_completely_paid_renewal_amt'];

    // $data['paid_recurring_count_for_current_month'] = count($current_month_completely_paid_renewal) + count($currentMonthpartially_paid_renewal);

     // ......................paid Renewal (Recurring) Year to Date ......................
    //     $yearToDatepartially_paid_renewal = Renewal::where([
    //         ['status', 'Partly paid'],
    //        ['main_acct_id', getActiveGuardType()->main_acct_id]
    //     ])->whereYear('created_at', $curr_year)->get();

    //      $year_to_date_completely_paid_renewal = Renewal::where([
    //         ['status', 'Paid'],
    //        ['main_acct_id', getActiveGuardType()->main_acct_id]
    //     ])->whereYear('created_at', $curr_year)->get();
      

    //  $data['yeartodate_partially_paid_renewal_amt'] = $yearToDatepartially_paid_renewal->sum('billingAmount') - $yearToDatepartially_paid_renewal->sum('billingBalance');

    //  $data['year_to_date_completely_paid_renewal_amt'] = $year_to_date_completely_paid_renewal->sum('billingAmount'); 

    //  $data['paid_recurring_amount_for_year_to_date'] = $data['yeartodate_partially_paid_renewal_amt'] + $data['year_to_date_completely_paid_renewal_amt'];

    // $data['paid_recurring_count_for_year_to_date'] = count($year_to_date_completely_paid_renewal) + count($yearToDatepartially_paid_renewal);

 // ......................paid Invoice for current mmonth......................
        // $currentMonthpartially_paid_invoice = Invoice::where([
        //     ['status', 'Partly paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();

        //  $current_month_completely_paid_invoice = Invoice::where([
        //     ['status', 'Paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();

        //  $data['current_month_paid_invoice_amount'] = $currentMonthpartially_paid_invoice->sum('amount_paid') + $current_month_completely_paid_invoice->sum('amount_paid');

        //  $data['current_month_paid_invoice_count'] = count($currentMonthpartially_paid_invoice) + count( $current_month_completely_paid_invoice);

 // ......................paid Invoice year tod date......................
        // $year_to_date_partially_paid_invoice = Invoice::where([
        //     ['status', 'Partly paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereYear('created_at', $curr_year)->get();

        //  $year_to_date_completely_paid_invoice = Invoice::where([
        //     ['status', 'Paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereYear('created_at', $curr_year)->get();

        //  $data['ytd_paid_invoice_amount'] = $year_to_date_partially_paid_invoice->sum('amount_paid') + $year_to_date_completely_paid_invoice->sum('amount_paid');

        //  $data['ytd_paid_invoice_count'] = count($year_to_date_partially_paid_invoice) + count( $year_to_date_completely_paid_invoice);

         // ......................outstanding Invoice for current mmonth......................
        // $current_Monthpartly_paid_invoice = Invoice::where([
        //     ['status', 'Partly paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();

        //  $current_month_pending_invoice = Invoice::where([
        //     ['status', 'Pending'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereMonth('created_at', $curr_momth)->get();

        //  $data['current_month_outstanding_invoice_amount'] = $current_Monthpartly_paid_invoice->sum('billingBalance') + $current_month_pending_invoice->sum('billingAmount');

        //  $data['current_month_outstanding_invoice_count'] = count($current_Monthpartly_paid_invoice) + count( $current_month_pending_invoice);

            // ......................outstanding Invoice since ytd......................
        // $year_to_date_partly_paid_invoice = Invoice::where([
        //     ['status', 'Partly paid'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereYear('created_at', $curr_year)->get();

        //  $year_to_date_pending_invoice = Invoice::where([
        //     ['status', 'Pending'],
        //    ['main_acct_id', getActiveGuardType()->main_acct_id]
        // ])->whereYear('created_at', $curr_year)->get();

        //  $data['ytd_outstanding_invoice_amount'] = $year_to_date_partly_paid_invoice->sum('billingBalance') + $year_to_date_pending_invoice->sum('billingAmount');

        //  $data['ytd_outstanding_invoice_count'] = count($year_to_date_partly_paid_invoice) + count($year_to_date_pending_invoice);

         // dd($data['ytd_outstanding_invoice_count']);

     return view('dashboard', $data);

    }
}
