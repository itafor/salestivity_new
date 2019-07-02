@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('View Opportunity')])


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
        $('#form1 button').prop("disabled", false);
        $('#form1 #addProduct').prop("disabled", false);
		$('#form1 #account').prop("disabled", false);
		$('#form1 #stage').prop("disabled", false);
		$('#form1 #status').prop("disabled", false);
		$('#edit').toggle();
		})
		
	});
</script>

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('View Opportunity') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('opportunity.update', [$opportunity->id]) }}" autocomplete="off" id="form1">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Opportunity information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('opportunity_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-opportunity">{{ __('Opportunity Name') }}</label>
                                            <input type="text" name="opportunity_name" id="input-opportunity" class="form-control form-control-alternative{{ $errors->has('opportunity_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Opportunity Name') }}" value="{{ $opportunity->name }}" required>

                                            @if ($errors->has('opportunity_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('opportunity_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('account') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-account">{{ __('Account') }}</label>
                                            <select name="account_id" id="account" class="form-control form-control-alternative{{ $errors->has('account_id') ? ' is-invalid' : '' }}" >
                                                <option value="">{{ $opportunity->customer->name }}</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('account_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('account_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('stage') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-stage">{{ __('Stage') }}</label>
                                            <select name="stage" id="stage" class="form-control form-control-alternative{{ $errors->has('stage') ? ' is-invalid' : '' }}" placeholder="{{ __('Stage') }}" value="{{ old('stage') }}" required >
                                                <option value="">{{$opportunity->stage}}</option>
                                                <option value="Qualification">Qualification</option>
                                                <option value="Needs Analysis">Needs Analysis</option>
                                            </select>
                                            @if ($errors->has('stage'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('stage') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-contact">{{ __('Contact') }}</label>
                                            <select name="contact" id="contact" class="form-control form-control-alternative{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact') }}" value="{{ old('contact') }}" disabled>
                                                <!-- Automatically filled according to an account picked using jquery -->
                                                    <option value="">{{ $opportunity->contact_person->name }}</option>
                                            </select>
                                            @if ($errors->has('contact'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('probability') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-probability">{{ __('Probability(%)') }}</label>
                                            <input type="text" name="probability" id="input-probability" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}" placeholder="{{ __('Probability') }}" value="{{ $opportunity->probability }}%">

                                            @if ($errors->has('probability'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('probability') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Amount(₦)') }}</label>
                                            <input type="text" name="amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount') }}" value="{{ $opportunity->amount }}">

                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('initiation_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-initiation_date">{{ __('Initiation Date') }}</label>
                                            <input type="date" name="initiation_date" id="input-initiation_date" class="form-control form-control-alternative{{ $errors->has('initiation_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Initiation Date') }}" value="{{ $opportunity->initiation_date }}" required>

                                            @if ($errors->has('initiation_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('initiation_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('closure_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-closure_date">{{ __('Expected Closure Date') }}</label>
                                            <input type="date" name="closure_date" id="input-closure_date" class="form-control form-control-alternative{{ $errors->has('closure_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Expected Closure Date') }}" value="{{ $opportunity->closure_date }}" required>

                                            @if ($errors->has('closure_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('closure_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('owner') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-owner">{{ __('Owner') }}</label>
                                            <input type="text" name="owner" id="input-owner" class="form-control form-control-alternative{{ $errors->has('owner') ? ' is-invalid' : '' }}" placeholder="{{ __('Owner') }}" value="{{ $opportunity->owner }}">

                                            @if ($errors->has('owner'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('owner') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                            <select name="status" id="status" class="form-control form-control-alternative{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact') }}" value="{{ old('contact') }}">
                                                <option value="Pending">{{ $opportunity->status }}</option>
                                                <option value="Won">Won</option>
                                                <option value="Lost">Lost</option>
                                            </select>
                                            @if ($errors->has('contact'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <br>
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

                                <br><br><br>
                                <div class="field_wrapper">
                                    
                                </div>

                                <div class="ml-auto" style="margin:20px;">
                                    <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                                    <a href="javascript:void(0);" class="add_button btn btn-primary" id="addProduct"><i class="fa fa-plus-circle"></i> Add Product</a>
                                        
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
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