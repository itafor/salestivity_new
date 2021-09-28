@extends('layouts.app', ['title' => __('Company Emails '), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Company Email Details')])
 <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        <h2>Company Email Details</h2>
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
        <div class="container">
    <div class="row">
      <form action="{{route('add.reply.to.email')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
      <div class="form-group mb-2 mr-1">
      <label for="reply_to_email" >ReplyTo Email</label>
      <input type="email" class="form-control-plaintext" name="reply_to_email" placeholder="Enter ReplyTo Email" required>
      @if ($errors->has('reply_to_email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('reply_to_email') }}</strong>
                    </span>
                @endif
      </div>
      <button type="submit" class="btn btn-primary mb--3">Add</button>
      </form>
      </div> 

      <div class="row">
      <div class="table-responsive">
      <table class="table">
      <thead>
      <tr>
      <th scope="col">ReplyTo Email</th>
      <th scope="col">Default</th>

      <th scope="col" colspan="2">Action</th>
      </tr>
      </thead>
      <tbody>
      @foreach($reply_to_emails as $email)
      <tr>
      <td>{{$email->reply_to_email}}</td>
      <td>{{$email->default_email}}</td>
      <td colspan="2">
      <a onclick="return confirm('Are you Sure?')" href="{{route('set.default.replyToEmail',[$email->id])}}">Set as default</a>
      <span onclick="getReplyToEmailById({{$email->id}})" type="button"  data-bs-toggle="modal" data-bs-target="#replyToEmail">
      <i class="fa fa-edit ml-1" title="edit email"></i>
      </span>
      </td>
      </tr>
      @endforeach
      </tbody>
      </table>
      </div>
      </div>
<hr>

 <div class="row">
      <form action="{{route('add.cc.email')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
      <div class="form-group mb-2 mr-1">
      <label for="cc_email" >CC Email</label>
      <input type="email" class="form-control-plaintext" name="cc_email" placeholder="Enter CC Email" required>
      @if ($errors->has('cc_email'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('cc_email') }}</strong>
                    </span>
                @endif
      </div>
      <button type="submit" class="btn btn-primary mb--3">Add</button>
      </form>
      </div> 

      <div class="row">
      <div class="table-responsive">
      <table class="table">
      <thead>
      <tr>
      <th scope="col">CC Email</th>

      <th scope="col" colspan="2">Action</th>
      </tr>
      </thead>
      <tbody>
      @foreach($cc_emails as $email)
      <tr>
      <td>{{$email->cc_email}}</td>
      <td colspan="2">
     
      <span onclick="getCcEmailById({{$email->id}})" type="button"  data-bs-toggle="modal" data-bs-target="#cc-email-modal">
      <i class="fa fa-edit ml-1" title="edit email"></i>
      </span>
      </td>
      </tr>
      @endforeach
      </tbody>
      </table>
      </div>
      </div>

<hr>

   <div class="row">
      <form action="{{route('add.mail.from.name')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
      <div class="form-group mb-2 mr-1">
      <label for="mail_from_name" >Mail From Name</label>
      <input type="text" class="form-control-plaintext" name="mail_from_name" placeholder="Enter Mail From Name" required>
      @if ($errors->has('mail_from_name'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first('mail_from_name') }}</strong>
                    </span>
                @endif
      </div>
      <button type="submit" class="btn btn-primary mb--3">Add</button>
      </form>
      </div> 

      <div class="row">
      <div class="table-responsive">
      <table class="table">
      <thead>
      <tr>
      <th scope="col">ReplyTo Email</th>
      <th scope="col">Default</th>

      <th scope="col" colspan="2">Action</th>
      </tr>
      </thead>
      <tbody>
      @foreach($mail_from_names as $email)
      <tr>
      <td>{{$email->mail_from_name}}</td>
      <td>{{$email->default_name}}</td>
      <td colspan="2">
      <a onclick="return confirm('Are you Sure?')" href="{{route('set.default.mail.from.name',[$email->id])}}">Set as default</a>
      <span onclick="getMailFromNameById({{$email->id}})" type="button"  data-bs-toggle="modal" data-bs-target="#mailFrormName">
      <i class="fa fa-edit ml-1" title="edit mail from name"></i>
      </span>
      </td>
      </tr>
      @endforeach
      </tbody>
      </table>
      </div>
      </div>
   

    </div> 
                   
<hr>
<div class="container">

<h3>Server Eamil Configuration Details </h3>
 <form action="{{route('company.add.email')}}" method="post">
            @csrf
<div class="row">
  <div class="col-4 mb-3">
    <label for="exampleInputEmail1" class="form-label">Driver</label>
    <input type="text" name="driver" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E.g. smtp" required>
@if ($errors->has('driver'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('driver') }}</strong>
    </span>
@endif
  </div>
  <div class="col-4 mb-3">
    <label for="exampleInputPassword1" class="form-label">Host Name</label>
    <input type="text" name="hostName" placeholder="E.g. smtp.googlemail.com" class="form-control" id="exampleInputPassword1" required>
    @if ($errors->has('hostName'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('hostName') }}</strong>
    </span>
@endif
  </div>
  <div class="col-4 mb-3">
    <label for="exampleInputPassword1" class="form-label">Port</label>
    <input type="text" name="port" placeholder="E.g. 465" class="form-control" id="exampleInputPassword1" required>
     @if ($errors->has('port'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('port') }}</strong>
    </span>
@endif
  </div>
</div>

<div class="row">
  <div class="col-4 mb-3">
    <label for="exampleInputEmail1" class="form-label">Encryption</label>
    <input type="text" name="encryption" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E.g. ssl" required>
@if ($errors->has('encryption'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('encryption') }}</strong>
    </span>
@endif
  </div>
  <div class="col-4 mb-3">
    <label for="exampleInputPassword1" class="form-label">User Name</label>
    <input type="text" name="userName" placeholder="E.g. example@gmail.com or 30cd411d798121" class="form-control" id="exampleInputPassword1" required>
    @if ($errors->has('userName'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('userName') }}</strong>
    </span>
@endif
  </div>
  <div class="col-4 mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" placeholder="Enter your password" class="form-control" id="exampleInputPassword1" required>
    <small>We'll never share your password with anyone else.</small> 

     @if ($errors->has('password'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('password') }}</strong>
    </span>
@endif
  </div>
</div>
<div class="row">
  <div class="col-6 mb-3">
    <label for="exampleInputEmail1" class="form-label">Sender Name</label>
    <input type="text" name="senderName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="E.g. John Doe" required>
@if ($errors->has('senderName'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('senderName') }}</strong>
    </span>
@endif
  </div>
  <div class="col-6 mb-3">
    <label for="exampleInputPassword1" class="form-label">Sender Email Address</label>
    <input type="email" name="company_email" placeholder="E.g. Johndoe@gmail.com" class="form-control" id="exampleInputPassword1" required>
    @if ($errors->has('company_email'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('company_email') }}</strong>
    </span>
@endif
  </div>
</div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
            </div>
    <hr>
    <div class="w3-container">
  <div class="row">
<div class="table-responsive">
            <table class="table">
  <thead>
    <tr>
      <th scope="col">Driver</th>
      <th scope="col">Host Name</th>
      <th scope="col">Port</th>
      <th scope="col">Encryption</th>
      <th scope="col">User Name</th>
      <th scope="col">Sender Name</th>
      <th scope="col">Sender Email</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($companyEmails as $email)
    <tr>
      <td>{{$email->driver}}</td>
      <td>{{$email->host}}</td>
      <td>{{$email->port}}</td>
      <td>{{$email->encryption}}</td>
      <td>{{$email->user_name}}</td>
      <td>{{$email->sender_name}}</td>
      <td>{{$email->email}}</td>
      <td>
        <span  class="mr-2" onclick="fetchCompanyEmail({{$email->id}})" style="cursor: pointer;"> <i class="fa fa-edit ml-1" title="edit email"></i></span>
      </td>
      
    </tr>
  @endforeach
  </tbody>
</table>
</div>
 </div>
</div>

</div>

  </div>

                 
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    @include('settings.editEmail')
    @include('settings.editReplyTOEmail')
    @include('settings.editCCEmail')
    @include('settings.editMailfromName')
   

    </div>


    <script type="text/javascript">
    // Delete data with ajax
function getReplyToEmailById(reply_to_email_id) {
// alert(reply_to_email_id)
$.ajax({
    url: baseUrl + "/company-emails/" + reply_to_email_id ,
    type: "GET",
    data: { reply_to_email_id: reply_to_email_id },
    success: function (data) {
        console.log('email: ',data.email);
    
        $("#reply_to_email_id").val(data.email.id)
        $("#reply_to_email").val(data.email.reply_to_email)
       
    },
});
}

function getMailFromNameById(mail_from_name_id) {
// alert(reply_to_email_id)
$.ajax({
    url: baseUrl + "/company-emails/mail_from_name/" + mail_from_name_id ,
    type: "GET",
    data: { mail_from_name_id: mail_from_name_id },
    success: function (data) {
        console.log('email: ',data.email);
    
        $("#mail_from_name_id").val(data.email.id)
        $("#mail_from_name").val(data.email.mail_from_name)
       
    },
});
}

function getCcEmailById(cc_email_id) {
// alert(reply_to_email_id)
$.ajax({
    url: baseUrl + "/company-emails/cc-email/" + cc_email_id ,
    type: "GET",
    data: { cc_email_id: cc_email_id },
    success: function (data) {
        console.log('email: ',data.email);
    
        $("#cc_email_id").val(data.email.id)
        $("#cc_email").val(data.email.cc_email)
       
    },
});
}


</script>
    @endsection