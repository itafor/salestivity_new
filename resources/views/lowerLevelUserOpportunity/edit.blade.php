@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Opportunity')])




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
                                <a href="{{ route('opportunity.view',[$opportunity->id]) }}" class="btn btn-sm btn-primary">{{ __('Back To List') }}</a>
                            </div>
                        </div>
                    </div>
  <div class="card-body">
         <form method="post" action="{{ route('opportunity.update') }}" autocomplete="off" id="form1">
                            @csrf
                            <div class="pl-lg-4">
                                <input type="hidden" name="opportunity_id" value="{{$opportunity->id}}">
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
                                            <select name="account_id" id="customer" class="form-control form-control-alternative{{ $errors->has('account_id') ? ' is-invalid' : '' }}" >
                                                
                                                @foreach($customers as $customer)
                                                    <option {{ $customer->id == $opportunity->customer->id ? 'selected': '' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                              
                                    <div class="col-xl-12">
                                        <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-contact">{{ __('Contact') }}</label>
                                            <select name="contact" id="contact_emails" class="form-control form-control-alternative{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact') }}" value="{{ old('contact') }}">
                                                <!-- Automatically filled according to an account picked using jquery -->
                                                    <option value="{{ $opportunity->contact_person ? $opportunity->contact_person->id : '' }}">{{ $opportunity->contact_person ? $opportunity->contact_person->surname .' '.$opportunity->contact_person->name : '' }}</option>
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
                                            <select  name="probability" id="input-probability" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}">
                                                <option value="{{$opportunity->probability}}">{{$opportunity->probability}}%</option>
                                                <option value="1">1%</option>
                                                <option value="25">25%</option>
                                                <option value="50">50%</option>
                                                <option value="75">75%</option>
                                                <option value="99">99%</option>
                                            </select>

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
                                            <input type="text" name="initiation_date" id="input-initiation_date" class="form-control form-control-alternative{{ $errors->has('initiation_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Initiation Date') }}" value="{{ \Carbon\Carbon::parse($opportunity->initiation_date)->format('d/m/Y')  }}" data-toggle="datepicker" required>

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
                                            <input type="text" name="closure_date" id="input-closure_date" class="form-control form-control-alternative{{ $errors->has('closure_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Expected Closure Date') }}" value="{{ \Carbon\Carbon::parse($opportunity->closure_date)->format('d/m/Y')  }}" data-toggle="datepicker" required>

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

                                            <select name="owner_id" class="form-control" >
                                                @foreach(mySubUsers() as $owner)
                                                <option value="{{$owner->id}}" {{$owner->id == $opportunity->owner_id ? 'selected'  : ''}}>{{$owner->name}} {{$owner->last_name}}</option>
                                                @endforeach
                                            </select>

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
                                            <select name="status" id="status" class="form-control form-control-alternative border-input {{ $errors->has('status') ? ' is-invalid' : '' }}" placeholder="{{ __('Status') }}" value="{{ old('status') }}">
                                                <option value="{{$opportunity->status}}">{{$opportunity->status}}</option>
                                                <option value="Prospecting">Prospecting</option>
                                                <option value="Qualifying">Qualifying</option>
                                                <option value="Needs Analysis">Needs Analysis</option>
                                                <option value="Presentation">Presentation</option>
                                                <option value="Proposal">Proposal</option>
                                                <option value="Negotiation">Negotiation</option>
                                                <option value="Closed Won">Closed Won</option>
                                                <option value="Closed Lost">Closed Lost</option>
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
                               

                                <br><br><br>
                                <div class="field_wrapper">
                                    
                                </div>

                                <div class="ml-auto" style="margin:20px;">
                                    <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                                    <a href="javascript:void(0);" class="add_button btn btn-primary" id="addProduct"><i class="fa fa-plus-circle"></i> Add Product</a>
                                        
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="save" class="btn btn-success mt-4">{{ __('Update') }}</button>
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