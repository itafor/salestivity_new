@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Opportunity')])


<script>
    $(document).ready(function(){
		/*Disable all input type="text" box*/
		$('#form1 input').prop("disabled", true);
		$('#form1 button').hide();
        $('#form1 #addProduct').hide();
        $('#form1 select').prop("disabled", true);
		$('#form1 #account').prop("disabled", true);
        
		$('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 button').show();
            $('#form1 select').prop("disabled", false);
        $('#form1 button').prop("disabled", false);
        $('#form1 #addProduct').prop("disabled", false);
		$('#form1 #account').prop("disabled", false);
		$('#form1 #stage').prop("disabled", false);
		$('#form1 #status').prop("disabled", false);
		$('#edit').toggle();
		})
		
	});
</script>

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">

        <div class="card">
      <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Opportunity Details') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('opportunity.edit',[$opportunity->id]) }}" class="btn btn-sm btn-info">{{ __('Edit') }}</a>
                                &nbsp;&nbsp;
                                <a href="{{ route('opportunity.view',[$opportunity->id]) }}" class="btn btn-sm btn-primary">{{ __('Back To List') }}</a>
                            </div>
                        </div>
                    </div>
  <div class="card-body">
        <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($opportunity))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Opportunity NAME') }}</b></td>
                     <td>{{ $opportunity->name }}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $opportunity->customer ? $opportunity->customer->name : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Contact Person') }}</b></td>
                     <td>{{ $opportunity->contact_person ? $opportunity->contact_person->name .' '.$opportunity->contact_person->surname :'N/A'  }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Owner') }}</b></td>
                     <td>{{ $opportunity->owner ? $opportunity->owner->name .' '.$opportunity->owner->last_name : 'N/A'  }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Probability') }}</b></td>
                     <td>{{ $opportunity->probability }} %
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Amount') }}</b></td>
                     <td>&#8358;{{ number_format($opportunity->amount,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td>
                        {{ $opportunity->status }} 
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __(' Initiation Date ') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($opportunity->initiation_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;"><b>{{ __('Expected Closure Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($opportunity->closure_date)) }}</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                <hr>
                   <h3>All Products</h3>
                                <div class="row">
                                    <div class="col-xl-6">
                                        @forelse($opportunity->products as $product)
                                            <span class="badge bg-purple">{{ $product->name }}</span>
                                        @empty
                                            <span class="badge bg-purple">No Product Added</span>
                                        @endforelse
                                    </div>
                </div>
  </div>
</div>

            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
<script>
    function selectAccountAjax(value) {
        $.get('/getcontact/' + value, function (data) {
            // console.log(data.contacts);
            $('#contact').html("");
            // $('#contact').append("<option value=''>Select Contact</option>");
            jQuery.each(data.contacts, function (i, val) {
                $('#contact').prop("disabled", false);
                $('#contact').append("<option value='" + val.id + "'>" + val.name + "</option>");
            });
        });
    }

    $('#account').change(function () {
        selectAccountAjax($(this).val());
    });



$(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = 		
    
                            '<div>'+
                            '<h2>Add Product(s)</h2>' +
								'<div class="row" id="fieldHTML">'+
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has("category") ? " has-danger" : "" }}">' +
											'<label class="form-control-label" for="input-category">{{ __('Category') }}</label>' +
											'<select name="category_id[]" id="category" class="form-control form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Category') }}" value="{{ old('category_id') }}">' +
                                                '<option value="">Select Category</option>' +
                                                '@foreach($categories as $category)'+
                                                    '<option value="{{$category->id}}">{{ $category->name }}</option>'+
                                                '@endforeach'+
                                            '</select>' +
                                        '</div>' +
                                        '@if ($errors->has('category_id'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('category_id') }}</strong>'+
                                                '</span>' +
                                        '@endif'+
									'</div>	' +
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}"> ' + 
											'<label class="form-control-label" for="sub_category">{{ __('Sub Category') }}</label>' +
											'<select name="sub_category_id[]" id="sub_category" class="form-control form-control-alternative{{ $errors->has('sub_category_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Sub Category') }}" value="{{ old('sub_category_id') }}">' +
                                                '<option value="">Select Sub Category</option>' +
                                                '@foreach($subCategories as $subCategory)'+
                                                    '<option value="{{$subCategory->id}}">{{ $subCategory->name }}</option>'+
                                                '@endforeach'+
                                            '</select>' +
                                        '</div>' +
                                        '@if ($errors->has('sub_category_id'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('sub_category_id') }}</strong>'+
                                                '</span>' +
                                        '@endif'+
										'</div>' +
                                    
								'</div>' +
								'<div class="row">' + 
									'<div class="col-xl-6">' + 
										'<div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">' +
											'<label class="form-control-label" for="product">{{ __('Product') }}</label>' +
											'<select name="product_id[]" id="product" class="js-example-basic-multiple form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Product') }}" value="{{ old('product_id') }}">' +
                                                '<option value="">Select Product</option>' +
                                                '@foreach($products as $product)'+
                                                    '<option value="{{$product->id}}">{{ $product->name }}</option>'+
                                                '@endforeach'+
                                            '</select>' +
												
											'@if ($errors->has('product_id'))'+
                                                '<span class="invalid-feedback" role="alert">' +
                                                    '<strong>{{ $errors->first('product_id') }}</strong>'+
                                                '</span>'+
                                            '@endif'+
										'</div>'+
									'</div>	' +
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has('Quantity') ? ' has-danger' : '' }}">' +
											'<label class="form-control-label" for="quantity">{{ __('Quantity') }}</label>'+
											'<input type="number" name="quantity[]" id="quantity" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" required >'+
											'@if ($errors->has('quantity'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('quantity') }}</strong>'+
                                                '</span>'+
                                            '@endif'+
										'</div>'+
									'</div>'+
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">' +
											'<label class="form-control-label" for="price">{{ __('Price') }}</label>'+
											'<input type="number" name="price[]" id="price" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}" required >'+
											'@if ($errors->has('price'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('price') }}</strong>'+
                                                '</span>'+
                                            '@endif'+
										'</div>'+
									'</div>'+
									'</div>' +
									'<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times"></i></a>'+ 
								'</div>'; //New input field html
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});



</script>
@endsection