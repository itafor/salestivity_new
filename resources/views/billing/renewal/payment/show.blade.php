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
                <th scope="col">{{ __('Amount Paid') }}</th>
                <th scope="col">{{ __('Cost') }}</th>
                <th scope="col">{{ __('Outstanding') }}</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>
                    @foreach($payment->product as $product)
                        {{ $product->name }},
                    @endforeach
                    </td>
                    <td>{{ $payment->status }}</td> 
                    <td>{{ $payment->discount }}%</td>
                    <td>{{ $payment->formatValue($payment->amount) }}</td>
                    <td>{{ $payment->formatValue($payment->cost) }}</td>
                    <td>{{ $payment->formatValue($payment->outstanding) }}</td>
                </tr>

                
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><b> ₦{{ $payment->formatValue($payments->sum('amount')) }} </b></td>
                <td><b> ₦{{ $payment->formatValue($payments->sum('cost')) }} </b></td>
                <td><b> ₦{{ $payment->formatValue($payments->sum('outstanding')) }} </b></td>
                </tr>                  
                @endforeach      
        </tbody>
    </table>    
</div>
