<div class="col-8">
	<h2 class="mb-0">{{ __('Payments') }}</h2>
</div>
					
<div class="table-responsive">
    <table class="table align-items-center table-flush">
        <thead>
            <tr>
                <th scope="col">{{ __('Product') }}</th>
                <th scope="col">{{ __('Status') }}</th>
                <th scope="col">{{ __('Billing AMT') }}</th>
                <th scope="col">{{ __('Amount Paid') }}</th>
                <th scope="col">{{ __('Outstanding') }}</th>
                <th scope="col">{{ __('Payment Date') }}</th>
                
            </tr>
        </thead>
        <tbody>
            @if($invoice->invoicePayment->count() >=1)
            @foreach($invoice->invoicePayment as $payment)
                <tr>
                    <td>{{$payment->product ? $payment->product->name : 'N/A' }}</td>
                    <td>{{$payment->status}}</td>
                     
                    <td>&#8358;{{ number_format($payment->billingAmount,2)}}</td>
                    <td>&#8358;{{ number_format($payment->amount_paid,2)}}</td>
                    <td>&#8358;{{ number_format($payment->billingbalance,2)}}</td>
                    <td>{{ date("jS F, Y", strtotime($payment->payment_date)) }}</td>
              </tr>                 
                @endforeach      
            @else
            <tr>
                <td colspan="8">
                <h5>No payment record found</h5> 
            <a onclick="invoice_payment({{$invoice->id}})" >
                <button class="btn btn-sm btn-primary" >
            {{ __('Make Payment') }}
            </button>
        </a>
                </td>
            </tr>
            @endif
        </tbody>
    </table>    
</div>
