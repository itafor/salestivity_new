@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Account')]) 
		
		<script>
			$(document).ready(function(){
				/*Disable all input type="text" box*/
				$('#form1 input').prop("disabled", true);
                $('#form1 button').hide();

                $('#edit').click(function(){
                $('#form1 input').prop("disabled", false);
                $('#form1 button').show();
                $('#edit').toggle();
                // $('#addContact').css("display","block");
                })
                $('#addContact').click(function() {
                    $('#saveContact').css("display", "block");
                    if('.remove_button' === 0) {
                        $('#saveContact').css("display", "none");
                    }
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
                                <h3 class="mb-0">{{ __('Edit Account') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form1" action="{{ route('customer.corporate.update', [$customer->id]) }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-company">{{ __('Company Name') }}</label>
                                    <input type="text" name="company_name" id="input-company" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Name') }}" value="{{ $customer->corporate->company_name }}" required autofocus>

                                    @if ($errors->has('company_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('industry') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-industry">{{ __('Industry') }}</label>
                                    <input type="text" name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ $customer->corporate->industry }}" required>

                                    @if ($errors->has('industry'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('industry') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ $customer->corporate->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ $customer->corporate->phone }}" required >

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                    <input type="url" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{ $customer->corporate->website }}" required >

                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                            <input type="text" name="state" id="input-state" class="form-control form-control-alternative{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ $address->state }}" required >

                                            {{--@if ($errors->has('state'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif--}}
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                            <input type="text" name="city" id="input-city" class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ $address->city }}" required >

                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-street">{{ __('Street') }}</label>
                                            <input type="text" name="street" id="input-street" class="form-control form-control-alternative{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{ $address->street }}" required >

                                            @if ($errors->has('street'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('street') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                            <input type="text" name="country" id="input-country" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ $address->country }}" required >

                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
								<input type="hidden" value="{{ $customer->id }}" name="customer_id[]">
                                <div class="text-center hide">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
					<br><br>
					<div class="col-8">
						<h2 class="mb-0">{{ __('Contacts') }}</h2>
					</div>
					
					<div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Surname') }}</th>
                                    <th scope="col">{{ __('Firstname') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $contact)
                                  <tr>
                                      <td>{{ $contact->title }}</td>
                                      <td>{{ $contact->surname }}</td>
                                      <td>{{ $contact->name }}</td>
                                      <td>{{ $contact->phone }}</td>
                                      <td>{{ $contact->email }}</td>
                                    <td>
                                        <div class="col-4 text-right">
                                                <a href="{{-- route('customer.contact.show', [$customer->id]) --}}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                        </div>
                                        <form action="{{-- route('customer.corporate.destroy', [$customer->id]) --}}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                            @csrf
                                            <div class="col-4 text-right">
                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{-- route('contact.destroy', [$customer->id]) --}}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                            @csrf
                                            <div class="col-4 text-right">
                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </div>
                                        </form>
                                    </td>
                                    
                                @endforeach
                                  </tr>
                            </tbody>
                        </table>    
                    </div>
                    <!-- <div class="row"> -->
                        <div class="col-xl-6" style="margin:20px;">
                            <form action="{{ route('customer.corporate.saveContacts', [$customer->id]) }}" method="post">
                                <div class="field_wrapper">
                                    @csrf
                                    <input type="hidden" value="{{ $customer->id }}" name="customer_id[]">
                                    <!-- Append each new contact form to this div -->
                                    
                                </div>
                                <div class="text-center hide">
                                    <button type="submit" class="btn btn-success mt-4" id="saveContact" style="display:none">{{ __('Save') }}</button>
                                </div>
                            </form>
                            
                        </div>    
                    <!-- </div> -->
                    <div class="ml-auto" style="margin:20px;">
                        <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                        <a href="javascript:void(0);" class="add_button btn btn-primary" id="addContact"><i class="fa fa-plus-circle"></i> Add Contact</a>
                            
                    </div>
                </div>
            </div>
			<br><br><br>
        </div>
					

        <script>
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = 		'<div>'+
								'<div class="row" id="fieldHTML">'+
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has("title") ? " has-danger" : "" }}">' +
											'<label class="form-control-label" for="input-title">{{ __('Title') }}</label>' +
											'<input type="text" name="contact_title[]" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" required >' +
										'</div>' +
									'</div>	' +
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has('contact_email') ? ' has-danger' : '' }}"> ' + 
											'<label class="form-control-label" for="input-email">{{ __('Email') }}</label>' +
											'<input type="text" name="contact_email[]" id="input-email" class="form-control form-control-alternative{{ $errors->has('contact_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required >' +
											'@if ($errors->has('contact_email'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('contact_email') }}</strong>'+
                                                '</span>' +
                                            '@endif'+
										'</div>' +
									'</div>'+
									
								'</div>' +
								'<div class="row">' + 
									'<div class="col-xl-6">' + 
										'<div class="form-group{{ $errors->has('contact_phone') ? ' has-danger' : '' }}">' +
											'<label class="form-control-label" for="input-phone">Phone</label>' +
											'<input type="number" name="contact_phone[]" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" required >'+
												
											'@if ($errors->has('contact_phone'))'+
                                                '<span class="invalid-feedback" role="alert">' +
                                                    '<strong>{{ $errors->first('contact_phone') }}</strong>'+
                                                '</span>'+
                                            '@endif'+
										'</div>'+
									'</div>	' +
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has('contact_surname') ? ' has-danger' : '' }}">' +
											'<label class="form-control-label" for="input-surname">{{ __('Surname') }}</label>'+
											'<input type="text" name="contact_surname[]" id="input-surname" class="form-control form-control-alternative{{ $errors->has('surname') ? ' is-invalid' : '' }}" placeholder="{{ __('Surname') }}" required >'+
											'@if ($errors->has('contact_surname'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('contact_surname') }}</strong>'+
                                                '</span>'+
                                            '@endif'+
										'</div>'+
									'</div>'+
									'<div class="col-xl-6">' +
										'<div class="form-group{{ $errors->has('contact_name') ? ' has-danger' : '' }}">' +
											'<label class="form-control-label" for="input-name">{{ __('First Name') }}</label>'+
											'<input type="text" name="contact_name[]" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" required >'+
											'@if ($errors->has('contact_name'))'+
                                                '<span class="invalid-feedback" role="alert">'+
                                                    '<strong>{{ $errors->first('contact_name') }}</strong>'+
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
	
        
        @include('layouts.footers.auth')
    </div>

@endsection