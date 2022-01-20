<!-- <div class="col-8">
	<h2 class="mb-0">{{ __('Products') }}</h2>
</div>
 -->					
<div class="table-responsive">
    <h2 class="mb-0">{{ __('Products') }}</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Category</th>
                <th>SubCategory</th>
                <th>Product</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @if($invoice->invoiceProducts->count() >=1)
            @foreach($invoice->invoiceProducts as $invoiceproduct)
                <tr>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->category->name : 'N/A' }}</td>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->sub_category->name : 'N/A' }}</td>
                    <td>{{$invoiceproduct->product ? $invoiceproduct->product->name : 'N/A' }}</td>
                    <td>{{$invoiceproduct->product ? number_format($invoiceproduct->product->standard_price,2) : 'N/A' }}</td>
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
