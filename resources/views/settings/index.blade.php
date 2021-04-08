@extends('layouts.app', ['title' => __('Company Details'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Company Details')])

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

          <form action="{{route('company.update.name')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group mx-sm-3 mb-2">
                <input type="hidden" name="company_detail_id" value="{{$companyDetail ? $companyDetail->id : ''}}">
            <input type="text" name="company_name" class="form-control" id="inputPassword2" placeholder="Company Name" value="{{$companyDetail ? $companyDetail->name : ''}}">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Save</button>
            </form>
        </div>
            </div>
<hr>
<h2>Emails</h2>
      <form action="{{route('company.add.email')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">Company Email</label>
            <input type="email" name="company_email" class="form-control" id="company-email" placeholder="Company Email" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Add</button>
            </form>
            <div class="w3-container">
  <div class="row">
    @foreach($companyEmails as $email)
    {{$email->email}} <span  class="mr-2" onclick="fetchCompanyEmail({{$email->id}})" style="cursor: pointer;"> <i class="fa fa-edit ml-1" title="edit email"></i></span>
    @endforeach
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