@extends('layouts.app', ['title' => __('Company Details'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Company Details')])
<style type="text/css">
  div { display: table; }
div.t {
    display: table-cell;
    width: 100%;
}
div.t > input {
    width: 100%;
}
</style>
 <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <!-- <h3 class="mb-0">{{ __('Logo') }}</h3> -->
                            </div>
                            <!-- <div class="col-4 text-right">
                                <a href="{{-- route('role.create') --}}" class="btn btn-sm btn-primary">{{ __('Add role') }}</a>
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
                          
                           <div class="row">
                            <div class="col-6">
           <h2>Company Logo</h2>

                            <form action="{{route('company.upload.logo')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="row g-3 align-items-center">
                     
                      <div class="col-auto">
                        <input type="file" name="company_logo_url" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline" required>
                      </div>
                      <div class="col-auto">
                        <span id="passwordHelpInline" class="form-text">
                         <button type="submit" class="btn btn-primary">Change Logo</button>
                        </span>
                      </div>
                    </div>
                </form>
                  @if(isset($user))
                           <img src="{{$user->company_logo_url}}" alt="company logo" width="100" height="100">
                            @endif
                        </div>
                   <div class="col-6">
           <h2>Company Name</h2>
          <form action="{{route('company.update.name')}}" method="post" autocomplete="off">
            @csrf
                <input type="hidden" name="company_detail_id" value="{{$companyDetail ? $companyDetail->id : ''}}">

                  <div style="width: 400px;">
                    <div class="t"> 
                         <input type="text" name="company_name"  id="inputPassword2" placeholder="Company Name" value="{{$companyDetail ? $companyDetail->name : ''}}" required>
            
                    </div>
                    <input type="submit" value="Save" />
                    </div>
            </form>

            <h2>Mail From Name</h2>
          <form action="{{route('company.update.mail_from_name')}}" method="post" autocomplete="off">
            @csrf
            <input type="hidden" name="company_detail_id" value="{{$companyDetail ? $companyDetail->id : ''}}">
                  <div style="width: 400px;">
          <div class="t"> 
               <input type="text" name="mail_from_name" class="" id="inputPassword2" placeholder="Company Name" value="{{$companyDetail ? $companyDetail->mail_from_name : ''}}" required>
          </div>
          <input type="submit" value="Save" />
      </div>
            
            </form>

            <h2>ReplyTo Email Address</h2>
          <form action="{{route('update.reply.to.email')}}" method="post" autocomplete="off">
            @csrf

             <input type="hidden" name="company_detail_id" value="{{$companyDetail ? $companyDetail->id : ''}}">



            <div style="width: 400px;">
              <div class="t"> <!-- This is the wrapper div around the text input -->
                  <input type="email" name="reply_to_email" class="" id="inputPassword2" placeholder="Company Reply To Email" value="{{$companyDetail ? $companyDetail->reply_to_email : ''}}" required>
              </div>
              <input type="submit" value="Save" />
          </div>
            </form>
        </div>
            </div>
<hr>
<div class="container">
<h2>Company Email Details</h2>

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
<hr>
<h2>Bank Account Details</h2>
     <form action="{{route('company.add.bank_account.detail')}}" method="post" class="form-inline" autocomplete="off">
            @csrf
            <div class="form-group mb-2 mr-1">
            <label for="staticEmail2" >Bank Name</label>
            <input type="text" class="form-control-plaintext" name="bank_name" placeholder="Bank Name" required>
            </div>
             <div class="form-group  mb-2 mr-1">
            <label for="staticEmail2">Account Name</label>
            <input type="text" name="account_name" class="form-control-plaintext" placeholder="Account Name" required>
            </div>
             <div class="form-group  mb-2 mr-1">
            <label for="staticEmail2">Account Number</label>
            <input type="number" name="account_number" class="form-control-plaintext"  placeholder="Account Number" required>
            </div>
            <button type="submit" class="btn btn-primary mb--3">Add</button>
            </form>
            @if(count($companyBankDetails) >=1)
            <div class="table-responsive">
            <table class="table">
  <thead>
    <tr>
      <th scope="col">Bank</th>
      <th scope="col">Account Name</th>
      <th scope="col">Account Number</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($companyBankDetails as $bankDetail)
    <tr>
      <td>{{$bankDetail->bank_name}}</td>
      <td>{{$bankDetail->account_name}}</td>
      <td>{{$bankDetail->account_number}}</td>
      <td><span class="" title="Edit Bank Account" onclick="fetchCompanyBankAccount({{$bankDetail->id}})" style="cursor: pointer;"><i class="fa fa-edit"></i></span></td>
      
    </tr>
  @endforeach
  </tbody>
</table>
</div>
@endif
                       </div>

                 
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    @include('settings.editEmail')
    @include('settings.editBankAccount')

    </div>
    @endsection