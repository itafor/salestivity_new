@extends('layouts.app', ['title' => __('Product Management')])

@section('content')
@include('users.partials.header', ['title' => __('All Sub Categories')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Sub Categories') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.subcategory.create') }}" class="btn btn-sm btn-primary">{{ __('Add Sub Category') }}</a>
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
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Created By') }}</th>
                                            <th scope="col">{{ __('Date Created') }}</th>
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subCategories as $sub)
                                          <tr>
                                            <td>{{ $sub->name }}</td>
                                            <td>{{ getCreatedByDetails($customer->user_type, $customer->created_by)['name'] .' '.
                                                    getCreatedByDetails($customer->user_type, $customer->created_by)['last_name']
                                                }}
                                            </td>
                                            <td>{{ strftime('%e %B %G', strtotime($sub->created_at)) }}</td>
                                            <td>
                                                <div class="btn-group-justified text-center" role="group">
                                                    <!-- <div class="btn-group" role="group">
                                                        <a href="{{ route('product.subcategory.show', [$sub->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                    </div>   -->

                                                    <div class="btn-group" role="group">
                                                        <form action="{{ route('product.subcategory.destroy', [$sub->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                            @csrf
                                                            <button type="submit" style="margin-right: 10px;" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                        </form>
                                                    </div>
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