<div class="col-8">
	<h2 class="mb-0">{{ __('Products') }}</h2>
</div>
					
<div class="table-responsive">
    <table class="table align-items-center table-flush">
        <thead>
            <tr>
                <th scope="col">{{ __('Category') }}</th>
                <th scope="col">{{ __('Sub Category') }}</th>
                <th scope="col">{{ __('Product') }}</th>
                <th scope="col">{{ __('Cost') }}</th>
                
            </tr>
        </thead>
        <tbody>
            @if($invoice->invoiceProducts->count() >=1)
            @foreach($invoice->invoiceProducts as $invoiceproduct)
                <tr>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->category->name : 'N/A' }}</td>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->sub_category->name : 'N/A' }}</td>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->name : 'N/A' }}</td>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->standard_price : 'N/A' }}</td>
              </tr>                 
                @endforeach      
            @else
            <tr>
                <td colspan="8">
                <h5>No product found</h5> 
          
                </td>
              
            </tr>
            @endif
        </tbody>
    </table>    
</div>
