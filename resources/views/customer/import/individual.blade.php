@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-university'])

@section('content')
@include('users.partials.header', ['title' => __('Import Customers')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header col-12  mb-10">
                      

                        <div class="row">
                            <div class="col-10">
                               <h4>Import Individual Accounts (Excel file only)</h4>
                            </div>
                            <div class="col-2">
             
                                <a href="{{ route('customer.corporate.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Corporate Account') }}"><i class="las la-folder-plus"></i></a>
                                <a href="{{ route('customer.individual.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Individual Account') }}"><i class="las la-user-plus"></i></a>
                                <a href="{{ route('customer.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                       
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        

                            
                                   <div class="row">
            <div class="col-6">

                            <form action="{{ route('import.individual.customers') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-success btn-sm">Import customers Data</button>
            </form>
                        </div>
            <div class="col-6">
            <a href="https://docs.google.com/spreadsheets/d/1K1Pj8Ermn9qrt0wc8hWutLTQSu69R-Yiy7LIKOhJJ_g/edit?usp=sharing" target="_blank">View sample here</a>    
            </div>
                        </div>  
                        </div>

                    </div>
            </div>
        </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection