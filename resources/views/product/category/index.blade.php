@extends('layouts.app', ['title' => __('Category Management'), 'icon' => 'las la-layer-group'])

@section('content')
@include('users.partials.header', ['title' => __('All Categories')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Categories') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.category.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Category') }}"><i class="las la-plus-circle"></i></a>
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
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Date Created') }}</th>
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($categories->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                @if(getCreatedByDetails($category->user_type, $category->created_by) !== null)
                                                    <td>{{ getCreatedByDetails($category->user_type, $category->created_by)['name'] .' '.
                                                            getCreatedByDetails($category->user_type, $category->created_by)['last_name']
                                                        }}
                                                    </td>
                                                @else
                                                    <td>Not Set</td>
                                                @endif
                                                <td>{{ strftime('%e %B %G', strtotime($category->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group-justified text-center" role="group">
                                                        <!-- <div class="btn-group" role="group">
                                                            <a href="{{ route('product.category.show', [$category->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                        </div>   -->

                                                        <div class="btn-group" role="group">
                                                            <form action="{{ route('product.category.destroy', [$category->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
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
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection