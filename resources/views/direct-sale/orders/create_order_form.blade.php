<form method="post" action="{{ route('order.store') }}" autocomplete="off">
@csrf
<input type="text" name="quantity" value="{{ last7DaysOrder($inventory->customer_id, $inventory->product_id) - $inventory->quantity }}">

<input type="hidden" name="customer_id" value="{{$inventory->customer_id}}">

<input type="hidden" name="product_id" value="{{$inventory->product_id}}">

<input type="hidden" name="category_id" value="{{ $inventory->product ?  $inventory->product->category->id : '' }}">

<input type="hidden" name="subcategory_id" value="{{ $inventory->product ?  $inventory->product->sub_category->id : '' }}">

<input type="hidden" name="status" value="Ordered">

<!-- <button type="submit">Submit</button> -->
<input type="submit" name="Submit" value="Create Order">
</form>