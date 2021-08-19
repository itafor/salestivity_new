@extends('layouts.app', ['title' => __('Currency Management'), 'icon' => 'las la-suitcase'])
@section('content')
@include('users.partials.header', ['title' => __('All currencies')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 mb-10">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Currencies') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('currency.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Currency') }}"><i class="las la-cart-plus"></i></a>
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
                        
                            
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Currency symbols') }}</th>
                                            <th scope="col">{{ __('Description') }}</th>
                                            
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($currencies->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($currencies as $currency)
                                            <tr>
                                                <td>{!! $currency->symbol !!}</td>
                                                <td>{!! $currency->description !!}</td>
                                              
                                                <td>
                                                    <div class="btn-group-justified text-center" role="group">
                                                        <!-- <div class="btn-group" role="group">
                                                            <a href="{{ route('currency.edit', [$currency->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>
                                                        </div>  -->
                                                        <div class="btn-group" role="group">
                                                            <form action="{{ route('destroy.currency.symbol', [$currency->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                                @csrf
                                                                <button type="submit" style="margin-right: 10px;" class="btn btn-sm btn-danger" title="Delete"><i class="las la-trash-alt"></i></button>
                                                            </form>
                                                        </div>                                                        
                                                    </div>                                                    
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
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