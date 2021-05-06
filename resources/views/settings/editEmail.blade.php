
<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form method="post" action="{{ route('company.update.email') }}" autocomplete="off">
           @csrf
    
    <div class="row">
  <div class="col-6 mb-3">
    <label for="exampleInputEmail1" class="form-label">Driver</label>
    <input type="text" name="driver" class="form-control" id="email_driver" aria-describedby="emailHelp" placeholder="E.g. smtp" required>
@if ($errors->has('driver'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('driver') }}</strong>
    </span>
@endif
  </div>
  <div class="col-6 mb-3">
    <label for="exampleInputPassword1" class="form-label">Host Name</label>
    <input type="text" name="hostName" placeholder="E.g. smtp.googlemail.com" class="form-control" id="email_hostname" required>
    @if ($errors->has('hostName'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('hostName') }}</strong>
    </span>
@endif
  </div>
</div>

    <div class="row">
  <div class="col-6 mb-3">
    <label for="exampleInputPassword1" class="form-label">User Name</label>
    <input type="text" name="userName" placeholder="E.g. example@gmail.com or 30cd411d798121" class="form-control" id="email_username" required>
    @if ($errors->has('userName'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('userName') }}</strong>
    </span>
@endif
  </div>
  <div class="col-6 mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" placeholder="Enter your password" class="form-control" id="email_password" required>
    <p style="font-size: 8px;">We'll never share your password with anyone else.</p> 

     @if ($errors->has('password'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('password') }}</strong>
    </span>
@endif
  </div>
</div>

   <div class="row">
  
  <div class="col-6 mb-3">
    <label for="exampleInputPassword1" class="form-label">Port</label>
    <input type="text" name="port" placeholder="E.g. 465" class="form-control" id="email_port" required>
     @if ($errors->has('port'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('port') }}</strong>
    </span>
@endif
  </div>

    <div class="col-6 mb-3">
    <label for="exampleInputEmail1" class="form-label">Encryption</label>
    <input type="text" name="encryption" class="form-control" id="email_encryption" aria-describedby="emailHelp" placeholder="E.g. ssl" required>
@if ($errors->has('encryption'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('encryption') }}</strong>
    </span>
@endif
  </div>
</div>


<div class="row">
  <div class="col-6 mb-3">
    <label for="exampleInputEmail1" class="form-label">Sender Name</label>
    <input type="text" name="senderName" class="form-control" id="sender_name" aria-describedby="emailHelp" placeholder="E.g. John Doe" required>
@if ($errors->has('senderName'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('senderName') }}</strong>
    </span>
@endif
  </div>
  <div class="col-6 mb-3">
    <label for="exampleInputPassword1" class="form-label">Sender Email Address</label>
    <input type="email" name="company_email" placeholder="E.g. Johndoe@gmail.com" class="form-control" id="company_email" required>
    @if ($errors->has('company_email'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('company_email') }}</strong>
    </span>
@endif
  </div>
</div>
   
<input type="hidden" name="company_email_id" class="form-control" id="company_email_id" placeholder="Enter Customer">
   
 
  
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
</form>

      </div>
      
    </div>
  </div>
</div>

  
