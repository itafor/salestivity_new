@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-university'])

@section('content')
@include('users.partials.header', ['title' => __('All Accounts')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header col-12  mb-10">
                         <div class="row">
            <div class="col-6">

                            <form action="{{ route('import.customers') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-success btn-sm">Import customers Data</button>
            </form>
                        </div>
            <div class="col-6">
            <a href="https://docs.google.com/spreadsheets/d/1K1Pj8Ermn9qrt0wc8hWutLTQSu69R-Yiy7LIKOhJJ_g/edit?usp=sharing">View sample here</a>    
            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-10">
                               <h4>All Customers</h4>
                            </div>
                            <div class="col-2">
             
                                <a href="{{ route('customer.corporate.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Corporate Account') }}"><i class="las la-folder-plus"></i></a>
                                <a href="{{ route('customer.individual.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Individual Account') }}"><i class="las la-user-plus"></i></a>
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
                        

                            
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('S/N') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Account Type') }}</th>
                                            <th scope="col">{{ __('Email') }}</th>
                                            <th scope="col">{{ __('Phone') }}</th>
                                            <th scope="col" class="text-center" >{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($customers->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($customers as $customer)
                                                <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $customer->name }}</td>
                                                        <td>{{ $customer->customer_type}}</td>
                                                        <td>{{ $customer->email }}</td>
                                                        <td>{{ $customer->phone }}</td>
                                                    <td>
                                                        <div class="btn-group-justified text-center" role="group">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('customer.show', [$customer->id]) }}" style="margin-right: 10px;" title="View" class="btn-icon btn-tooltip btn-sm btn-success" ><i class="las la-eye"></i></a>
                                                            </div>  

                                                            <div class="btn-group" role="group">
                                                                <a onclick="deleteData('customer','destroy',{{$customer->id}})" class="btn-icon btn-tooltip" title="Delete"><i class="las la-trash-alt"></i></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>    
                        </div>
                            {{$customers->render("pagination::bootstrap-4")}}

                    </div>
            </div>
        </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection