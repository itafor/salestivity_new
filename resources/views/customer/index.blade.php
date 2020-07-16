@extends('layouts.app', ['title' => __('Account Management')])

@section('content')
@include('users.partials.header', ['title' => __('All Accounts')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header col-12">
                        <div class="row">
                            <div class="col-6  text-left">
                                <a href="{{ route('customer.corporate.create') }}" class="btn btn-sm btn-primary">{{ __('Add Corporate account') }}</a>
                            </div>
                            <div class="col-6  text-right">
                                <a href="{{ route('customer.individual.create') }}" class="btn btn-sm btn-primary">{{ __('Add Individual account') }}</a>
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
                        

                            <div class="table-responsive">
                                <table class="table  table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('S/N') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Account Type') }}</th>
                                            <th scope="col">{{ __('Email') }}</th>
                                            <th scope="col">{{ __('Phone') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col" class="text-center" >{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customers as $customer)
                                          <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->customer_type}}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                @if(getCreatedByDetails($customer->user_type, $customer->created_by) !== null)
                                                    <td>{{ getCreatedByDetails($customer->user_type, $customer->created_by)['name'] .' '.
                                                        getCreatedByDetails($customer->user_type, $customer->created_by)['last_name']
                                                        }}
                                                    </td>
                                                @else
                                                    <td>Not Set</td>
                                                @endif
                                            <td>
                                                <div class="btn-group-justified text-center" role="group">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('customer.show', [$customer->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                    </div>  

                                                    <div class="btn-group" role="group">
                                                                     <a onclick="deleteData('customer','destroy',{{$customer->id}})"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a>
                                                    </div>
                                                </div>
                                            </td>
                                        @endforeach
                                          </tr>
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection