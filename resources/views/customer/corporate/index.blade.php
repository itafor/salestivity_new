@extends('layouts.app', ['title' => __('Account Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add Account')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Accounts') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary">{{ __('Create account') }}</a>
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
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Industry') }}</th>
                                            <th scope="col">{{ __('Email') }}</th>
                                            <th scope="col">{{ __('Phone') }}</th>
                                            <th scope="col">{{ __('Website') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customers as $customer)
                                          <tr>
                                              <td>{{ $customer->company_name }}</td>
                                              <td>{{ $customer->industry }}</td>
                                              <td>{{ $customer->email }}</td>
                                              <td>{{ $customer->phone }}</td>
                                              <td>{{ $customer->website }}</td>
                                              @if(getCreatedByDetails($customer->user_type, $customer->created_by) !== null)
                                                    <td>{{ getCreatedByDetails($customer->user_type, $customer->created_by)['name'] .' '.
                                                        getCreatedByDetails($customer->user_type, $customer->created_by)['last_name']
                                                        }}
                                                    </td>
                                                @else
                                                    <td>Not Set</td>
                                                @endif
                                            <td>
                                                <div class="col-4 text-right">
                                                        <a href="{{ route('customer.show', [$customer->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                </div>
                                                <form action="{{ route('customer.destroy', [$customer->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                    @csrf
                                                    <div class="col-4 text-right">
                                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                    </div>
                                                </form>
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
            


    @include('layouts.footers.auth')
  </div>
@endsection