@extends('layouts.app', ['title' => __('Product Management'), 'icon' => 'las la-suitcase'])
@section('content')
@include('users.partials.header', ['title' => __('All Products')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 mb-10">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Products') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Product') }}"><i class="las la-cart-plus"></i></a>
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
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Description') }}</th>
                                            <th scope="col">{{ __('Standard Price') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($products->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>{!!$product->currency ? $product->currency->symbol:'&#8358;'  !!}{{ $product->standard_price }}</td>
                                                @if(getCreatedByDetails($product->user_type, $product->created_by) !== null)
                                                    <td>{{ getCreatedByDetails($product->user_type, $product->created_by)['name'] .' '.
                                                            getCreatedByDetails($product->user_type, $product->created_by)['last_name']
                                                        }}
                                                    </td>
                                                @else
                                                    <td>Not Set</td>
                                                @endif
                                                <td>
                                                    <div class="btn-group-justified text-center" role="group">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('product.show', [$product->id]) }}" style="margin-right: 10px;" class="btn-icon btn-tooltip" title="View"><i class="las la-eye"></i></a>
                                                        </div> 
                                                        <div class="btn-group" role="group">
                                                             <a onclick="return confirm('Do you really want to delete this item?');" href="{{route('product.destroy', [$product->id]) }}" class="btn-icon btn-tooltip" title="Delete"><i class="las la-trash-alt"></i></a>
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
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection