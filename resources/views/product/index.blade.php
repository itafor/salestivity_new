@extends('layouts.app', ['title' => __('Product Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add Product')]) 

      
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
                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">{{ __('Create Product') }}</a>
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
                                    <th scope="col">{{ __('Category') }}</th>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                  <tr>
                                      <td>{{ $product->name }}</td>
                                      <td>{{ $product->category }}</td>
                                      <td>{{ $product->type }}</td>    
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