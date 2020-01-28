<div class="col-8">
	<h2 class="mb-0">{{ __('Payments') }}</h2>
</div>
					
<div class="table-responsive">
    <table class="table align-items-center table-flush">
        <thead>
            <tr>
                <th scope="col">{{ __('Products') }}</th>
                <th scope="col">{{ __('Status') }}</th>
                <th scope="col">{{ __('Discount') }}</th>
                <th scope="col">{{ __('Billing AMT') }}</th>
                <th scope="col">{{ __('Amount Paid') }}</th>
                <th scope="col">{{ __('Outstanding') }}</th>
                <th scope="col">{{ __('Payment Date') }}</th>
                
            </tr>
        </thead>
        <tbody>
            @if($renewalPayments->count() >=1)
            @foreach($renewalPayments as $payment)
                <tr>
                    <td>{{$payment->product ? $payment->product->name : 'N/A' }}</td>
                    <td>{{$payment->status}}</td>
                    <td>{{$payment->discount}}</td>
                    <td>{{$payment->billingAmount}}</td>
                    <td>{{$payment->amount_paid}}</td>
                    <td>{{$payment->billingbalance}}</td>
                    <td>{{ date("jS F, Y", strtotime($payment->payment_date)) }}</td>
              </tr>                 
                @endforeach      
            @else
            <tr>
                <td colspan="8">
                <h5>No payment record found</h5> 
            <a onclick="renewalPayment({{$renewal->id}})" >
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
