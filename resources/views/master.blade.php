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