@extends('layouts.app', ['title' => __('Billing')])

@section('content')
@include('users.partials.header', ['title' => __('All Renewals')]) 

      
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Renewals') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.create') }}" class="btn btn-sm btn-primary">{{ __('Create Renewal') }}</a>
                            </div>
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
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Customer') }}</th>
                                    <th scope="col">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Amount') }}</th>
                                    <th scope="col">{{ __('Period') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($renewals as $renewal)
                                    <tr>
                                    
                                        <td>{{ $renewal->customer }}</td>
                                        <td>{{ $renewal->product }}</td>
                                        <td>{{ $renewal->amount }}</td>
                                        <td>{{ $renewal->period }}</td>
                                        <td>
                                            <div class="col-4 text-right">
                                                <a href="{{ route('billing.renewal.show', [$renewal->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('billing.renewal.destroy', [$renewal->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
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
            


    @include('layouts.footers.auth')
  </div>
@endsection