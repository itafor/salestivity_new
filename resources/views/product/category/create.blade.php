@extends('layouts.app', ['title' => __('Category Managment'), 'icon' => 'las la-plus-circle'])
@section('content')
@include('users.partials.header', ['title' => __('Add Category')])  

<div class="container-fluid mt--7 main-container">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8 ">
                            <h3 class="mb-0">{{ __('Add New Category') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('product.category.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('product.category.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Add Category') }}</h6>
                            <div class="pl-lg-4 pr-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name">{{ __('Category Name *') }}</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Category Name') }}" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
<br>
                                <div class=" field_wrapper form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
    
                                    <!-- <input type="hidden" value="" name="customer_id[]"> -->
                                    <!-- Append each new contact form to this div -->   
                                    </div>
                                    <div class="ml-auto" style="margin:20px;">
                                        <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                                        <a href="javascript:void(0);" class="add_button btn btn-primary" id="addContact"><i class="fa fa-plus-circle"></i> Add New Category</a>
                                    </div>
                            
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
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
                var fieldHTML = '<div>'+ 
                                    '<input type="text" name="addCategory[]" id="addCategory" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Category Name') }}" value="{{ old('name') }}" required autofocus>' +

                                        '@if ($errors->has('name'))' +
                                            '<span class="invalid-feedback" role="alert">' +
                                                '<strong>{{ $errors->first('name') }}</strong>' +
                                            '</span>' +
                                        '@endif' +
                                        '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times"></i></a>' +
                                        '</div>'
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