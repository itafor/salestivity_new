@extends('layouts.app', ['title' => __('Company Bank Account'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Company Bank Account Details')])

 <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        
                            <h2>Bank Account Details</h2>

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

                          
<!-- <hr> -->

<div class="card-body">
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
</div>
@endif
                       </div>

                 
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
  
    @include('settings.editBankAccount')

    </div>
    @endsection