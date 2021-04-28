@extends('layouts.app', ['title' => __('Target Management'), 'icon' => 'las la-bullseye'])
@section('content')
@include('users.partials.header', ['title' => __('All Targets')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Targets') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('target.create') }}" class="btn-icon btn-tooltip" title="{{ __('Build Target') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="col-11">
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
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Sales Person') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Start Date') }}</th>
                                            <th scope="col">{{ __('End Date') }}</th>
                                            <th scope="col">{{ __(' Amount') }}</th>
                                            <!-- <th scope="col">{{ __('Amount Achieved') }}</th>
                                            <th scope="col">{{ __('Percentage Achieved') }}</th> -->
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($targets->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($targets as $target)
                                                <tr>
                                                    <td>{{ $target->salesPerson->name ?? '' }}</td>
                                                    @if(getCreatedByDetails($target->user_type, $target->created_by) !== null)
                                                        <td>{{ getCreatedByDetails($target->user_type, $target->created_by)['name'] .' '.
                                                                getCreatedByDetails($target->user_type, $target->created_by)['last_name']
                                                            }}
                                                        </td>
                                                    @else
                                                        <td>Not Set</td>
                                                    @endif

                <td>{{ $target->start_date ?  date("jS F, Y", strtotime($target->start_date)) : 'N/A' }}</td>           

                <td>{{ $target->end_date ? date("jS F, Y", strtotime($target->end_date)) : 'N/A'}}</td>           
                                                    <td> &#8358;{{ number_format($target->products->sum('amount'), 2) }}</td>
                                                   <!--  <td>{{ $target->amt_achieved }}</td>
                                                    <td>{{ $target->percentage }}%</td> -->
                                                    <td>
                                                        <span>
                                                            <div class="col-4 text-right">
                                                                <a href="{{ route('target.show', [$target->id]) }}" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>

                                                                <a onclick="return confirm_delete()"  href="{{route('items.destroy',['target',$target->id])}}" title="Delete"><button class="btn  text-danger">
                                                             <i class="las la-trash"></i>
                                                         </button>
                                                            
                                                        </a>
                                                            </div>
                                                        </span>
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
            


    @include('layouts.footers.auth')
  </div>
@endsection