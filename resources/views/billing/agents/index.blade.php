@extends('layouts.app', ['title' => __('Billing'), 'icon' => 'las la-file-invoice-dollar'])

@section('content')
@include('users.partials.header', ['title' => __('All Billing Agents')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Billing Agents') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.agent.create') }}" class="btn btn-sm btn-primary">{{ __('Create Billing Agent') }}</a>
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
                        

                            <div class="table-responsive">
                                <table class="table  table-bordered table-hover datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th ><b>{{ __('S/N') }}</b></th>
                                            <th ><b>{{ __('Customer') }}</b></th>
                                            <th ><b>{{ __('Name') }}</b></th>
                                            <th ><b>{{ __('Phone') }}</b></th>
                                            <th ><b>{{ __('Email') }}</b></th>
                                            <th class="text-center"><b>{{ __('Action') }}</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($billing_agents as $agent)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $agent->customer->name }}</td>
                                            <td>{{ $agent->name}}</td>
                                            <td>{{ $agent->phone}}</td>
                                            <td>{{ $agent->email}}</td>
                                           
                                            
                                            <td>
                                                <div class="col-4 text-right">                                                   
                                                    <a onclick="deleteData('billing','agent',{{$agent->id}})"><button class="btn btn-sm btn-danger" title="Delete"><i class="las la-trash-alt"></i></button></a>
                                                </div>
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
        </div>
            


    @include('layouts.footers.auth')
   
  </div>
@endsection