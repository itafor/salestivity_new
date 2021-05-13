@extends('layouts.zeus_layout', ['title' => __('Add City')])
@section('content')
@include('zeus.partials.header', ['title' => __('City')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add new city to a state') }}</h3>
                            </div>
                        <!-- <div class="col-4 text-right">
                                <a href="{{ route('admin.location.view.cities') }}" class="btn-icon btn-tooltip" title="{{ __('view Cities') }}"><i class="las la-plus-circle">View cities</i></a>
                            </div> -->
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
                        <form method="post" action="{{ route('admin.location.add.city') }}" autocomplete="off">
                            @csrf
                             <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="country_id">{{ __('Country') }}</label>
                                            <select name="country" id="country_id" class="form-control form-control-alternative border-input{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country') }}" required >
                                                <option value="">Select a country</option>
                                                @foreach(getCountries() as $country)
                                                    <option {{ $country->sortname == $location ? "selected" : "" }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('State') }}</label>
                                            <select name="state" id="state_id" class="form-control form-control-alternative border-input{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state') }}" required >
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('state'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                
                                </div> 




                  <div class="col-md-6">
                  <label class="form-control-label" for="input-property_type">{{ __('City') }}</label>
                  <input type="text" name="cities[112211][name]"  class="form-control" required>
                </div>

                <div style="clear:both"></div>
                <div id="cityContainer" class="col-md-6">
                </div>   
                <div style="clear:both"></div>

                   <div class="form-group mt-3">
                  <button type="button" id="addMoreCities" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>  Add another city</button>
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
                                    '<input type="text" name="addSubCategory[]" id="addSubCategory" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Category Name') }}" value="{{ old('name') }}" required autofocus>' +

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