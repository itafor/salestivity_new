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
                                <h3 class="mb-0">{{ __('Logo') }}</h3>
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
                            @if(isset($user))
                           <img src="{{$user->company_logo_url}}" alt="company logo" width="200" height="200">
                            @endif
                           
                            <form action="{{route('company.upload.logo')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="row g-3 align-items-center">
                     <!--  <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">Company Logo</label>
                      </div> -->
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
                    <hr>
           <h2>Name</h2>

                            <form class="form-inline">
            <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">Company Name</label>
            <input type="text" name="company_name" class="form-control" id="inputPassword2" placeholder="Company Name">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Save</button>
            </form>
<hr>
<h2>Emails</h2>
     <form class="form-inline">
           
            <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">Company Email</label>
            <input type="email" name="company_email" class="form-control" id="company_email" placeholder="Company Email">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Save</button>
            </form>
<hr>
<h2>Bank Account Details</h2>
     <form class="form-inline">
            <div class="form-group mb-2 mr-1">
            <label for="staticEmail2" >Bank Name</label>
            <input type="text" class="form-control-plaintext" name="bank_name" id="bank_name" placeholder="Bank Name">
            </div>
             <div class="form-group  mb-2 mr-1">
            <label for="staticEmail2">Account Name</label>
            <input type="text" name="account_name" class="form-control-plaintext" id="account_name" placeholder="Account Name">
            </div>
             <div class="form-group  mb-2 mr-1">
            <label for="staticEmail2">Account Number</label>
            <input type="number" name="account_number" class="form-control-plaintext" id="account_name" placeholder="Account Number">
            </div>
            <button type="submit" class="btn btn-primary mb--3">Save</button>
            </form>
                       </div>

                 
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
    @endsection