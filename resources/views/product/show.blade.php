@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Product')]) 
		
<script>
    $(document).ready(function(){
        /*Disable all input type="text" box*/
        $('#form1 input').prop("disabled", true);
        $('#form1 select').prop("disabled", true);
        $('#form1 button').hide();

        $('#edit').click(function(){
        $('#form1 input').prop("disabled", false);
        $('#form1 select').prop("disabled", false);
        $('#form1 button').show();
        $('#edit').toggle();
        })
        
    });
		</script> 

<div class="container-fluid mt--7">
        <div class="row">
<div class="col-xl-12 order-xl-1">
            <div class="card">
  <div class="card-header">
   <div class="float-left">Product Details</div>
    <div class="float-right">
      <a href="{{route('product.edit',[$product->id])}}">
        <button class="btn btn-info btn-sm">Edit</button>
      </a> ||  <a href="{{route('product.index')}}">
        <button class="btn btn-success btn-sm">Back to List</button>
      </a>
    </div>
  </div>
  <div class="card-body">
             <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($product))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Name') }}</b></td>
                     <td>{{$product->name}}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Category') }}</b></td>
                     <td>{{ $product->category ? $product->category->name :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Subcategory') }}</b></td>
                     <td>{{ $product->sub_category ? $product->sub_category->name :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td>&#8358;{{ number_format($product->standard_price,2) }}
                     </td>
                   </tr>

              
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Discription') }}</b></td>
                     <td>{{ $product->description }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __(' Date Created') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($product->created_at)) }}</td>           
              </tr>
             

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table> 
  </div>
</div>
         </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection