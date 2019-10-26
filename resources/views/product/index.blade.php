@extends('layouts.app', ['title' => __('Product Management')])

@section('content')
@include('users.partials.header', ['title' => __('All Products')]) 

      
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Products') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">{{ __('Add Product') }}</a>
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
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Standard Price') }}</th>
                                    <th scope="col" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                  <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->standard_price }}</td>
                                    <td>
                                        <div class="btn-group-justified text-center" role="group">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('product.show', [$product->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                            </div>  

                                            <div class="btn-group" role="group">
                                                <form action="{{ route('product.destroy', [$product->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                    @csrf
                                                    <button type="submit" style="margin-right: 10px;" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- <td>   
                                    <span>
                                        <div class="col-4 text-right">
                                            <a href="{{ route('product.show', [$product->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                        </div>
                                    </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('product.destroy', [$product->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                            @csrf
                                            <div class="col-4 text-right">
                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                            </div>
                                        </form>
                                        </span>
                                    </td>     -->
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