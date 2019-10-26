@extends('layouts.app', ['title' => __('Account Management')])

@section('content')
@include('users.partials.header', ['title' => __('All Accounts')]) 

      
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Accounts') }}</h3>
                            </div>
                            <!-- <div class="col-4 text-right">
                                <a href="{{-- route('customer.create') --}}" class="btn btn-sm btn-primary">{{ __('Add account') }}</a>
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
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Account Type') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col" class="text-center" >{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                  <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $cus = $customer->account_type == 1 ? 'Corporate' : 'Individual'}}</td>
                                        @if($customer->account_type == 1)
                                            <td>{{ $customer->corporate->email }}</td>
                                            <td>{{ $customer->corporate->phone }}</td>
                                        @else
                                            <td>{{ $customer->individual->email }}</td>
                                            <td>{{ $customer->individual->phone }}</td>
                                        @endif
                                    <td>
                                        <div class="btn-group-justified text-center" role="group">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('customer.'.strtolower($cus).'.show', [$customer->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                            </div>  

                                            <div class="btn-group" role="group">
                                                <form action="{{ route('customer.'.strtolower($cus).'.destroy', [$customer->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                    @csrf
                                                    <button type="submit" style="margin-right: 10px;" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                </form>
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
            


    @include('layouts.footers.auth')
  </div>
@endsection