@extends('layouts.app', ['title' => __('Company Details'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Company Details')])

 <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                       <h2>Company Details</h2>
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
                            <div class="col-12">
           <h2>Logo</h2>

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
           <h2 class="mt-30">Company Name</h2>
          <form action="{{route('company.update.name')}}" method="post" autocomplete="off" class="form-inline ">
            @csrf
                 
                    <div class="col-auto">
                         <input type="text" name="company_name" class="form-control"  id="inputPassword2" placeholder="Company Name" value="{{$user ? $user->company_name : ''}}" required>
                       </div>
                       <div class="col-auto">
                    <button  type="submit" class="btn btn-primary">Save</button>
            
                    </div>
                                </form>

         
        </div>
            </div>

  

         </div>

                 
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    

    </div>
    @endsection