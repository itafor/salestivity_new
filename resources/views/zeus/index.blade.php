@extends('layouts.zeus_layout', ['title' => __('Add Product')])
@section('content')
@include('zeus.partials.header', ['title' => __('All Accounts')])
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

                    <div class="table-responsive">
                        <table class="table align-items-center table-bordered datatable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Organization') }}</th>
                                    <th scope="col">{{ __('Primary Email') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col">{{ __('No of accounts') }}</th>
                                    <!-- <th scope="col">{{ __('No of users') }}</th> -->
                                    
                                    <!-- <th scope="col">{{ __('Date Created') }}</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tables as $key => $table)
                                    <tr>
                                        <td>{{$table->company_name}}</td>
                                        <td>{{$table->email}}</td>
                                        <td>{{$table->phone}}</td>
                                        <td>{{ $table->organization_count }}</td>
                                        <!-- <td>{{-- strftime('%d-%b-%Y', strtotime($role->created_at)) --}}</td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>

@endsection