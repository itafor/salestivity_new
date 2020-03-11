@extends('layouts.app', ['title' => __('Add Department')])
@section('content')
@include('users.partials.header', ['title' => __('Add Department')])  

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Department') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('dept.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('dept.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Department/Unit') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('dept') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="dept">{{ __('Department') }}</label>
                                            <input type="text" name="dept" id="dept" class="form-control form-control-alternative{{ $errors->has('dept') ? ' is-invalid' : '' }}" placeholder="{{ __('Department') }}" value="{{ old('dept') }}" required autofocus>

                                            @if ($errors->has('dept'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dept') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="unit">{{ __('Unit') }}</label>
                                            <input type="text" name="unit" id="unit" class="form-control form-control-alternative{{ $errors->has('unit') ? ' is-invalid' : '' }}" placeholder="{{ __('Unit') }}" value="{{ old('unit') }}" required>

                                            @if ($errors->has('unit'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('unit') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
      
                                    
                                </div>
                                <div class="row">
                                    
                                </div>
                                <!-- <div class="row"> -->
                                    
                                        <div class="row field_wrapper form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        
                                        <!-- <input type="hidden" value="" name="customer_id[]"> -->
                                        <!-- Append each new contact form to this div -->   
                                        </div>
                    
                                    
                                    

                                <!-- </div> -->
                                
                                <div class="ml-auto" style="margin:20px;">
                                        <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                                        <a href="javascript:void(0);" class="add_button btn btn-primary" id="addContact"><i class="fa fa-plus-circle"></i> Add New Unit</a>
                                </div>
                            
                            
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

        <script>
            $(document).ready(function(){
                var maxField = 10; //Input fields increment limitation
                var addButton = $('.add_button'); //Add button selector
                var wrapper = $('.field_wrapper'); //Input field wrapper
                var fieldHTML = 
                                    '<div class="col-xl-12 addnew">'+ 
                                        '<label class="form-control-label" for="unit">{{ __('Unit') }}</label>'+
                                        '<input type="text" name="addUnit[]" id="addUnit" class="form-control form-control-alternative{{ $errors->has('addUnit') ? ' is-invalid' : '' }}" placeholder="{{ __('Unit') }}" value="{{ old('addUnit') }}" required>' +

                                        '@if ($errors->has('addUnit'))' +
                                            '<span class="invalid-feedback" role="alert">' +
                                                '<strong>{{ $errors->first('addUnit') }}</strong>' +
                                            '</span>' +
                                        '@endif' +
                                        '<button class="badge bg-purple remove_button">Remove</button>' +
                                    '</div>'
                                //     '<div class="col-xl- addnew">'+ 
                                //     '<label class="form-control-label" for="unit">{{ __('Unit Head') }}</label>'+
                                //     '<input type="text" name="addUnitHead[]" id="addUnit" class="form-control form-control-alternative{{ $errors->has('addUnit') ? ' is-invalid' : '' }}" placeholder="{{ __('Unit') }}" value="{{ old('addUnit') }}" required>' +

                                //     '@if ($errors->has('addUnit'))' +
                                //         '<span class="invalid-feedback" role="alert">' +
                                //             '<strong>{{ $errors->first('addUnit') }}</strong>' +
                                //         '</span>' +
                                //     '@endif'  +
                                //     '<button class="badge bg-purple remove_button">Remove</button>' +
                                // '</div>'
                                
                                
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
        
        @include('layouts.footers.auth')
    </div>

@endsection