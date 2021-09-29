@extends('layouts.app', ['title' => __('Location Management'), 'icon' => 'las la-map-marker-alt'])
@section('content')
@include('users.partials.header', ['title' => __('Add Sales Location')])

<div class="container-fluid mt--7">
        <div class="row">
<div class="col-xl-12 order-xl-1">
  <div class="card shadow">
  

    <div class="card-header bg-white">
      <div class="row align-items-center">
          <div class="col-8">
              <h3 class="mb-0">{{ __('Location Details') }}</h3>
          </div>
          <div class="col-4 text-right">
              <a href="{{route('sales.location.edit',[$location->id])}}" class="btn-icon btn-tooltip" title="{{ __('Edit') }}"><i class="las la-edit"></i></a>
              <a href="{{ route('sales.location.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
          </div>
      </div>
    </div>


  <div class="card-body">
             <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($location))
                    <tbody>

                         <tr>
                     <td style="width: 200px;"><b>{{ __('Author') }}</b></td>
                    @if(getCreatedByDetails($location->user_type, $location->created_by) !== null)
                            <td>{{ getCreatedByDetails($location->user_type, $location->created_by)['name'] .' '.
                                    getCreatedByDetails($location->user_type, $location->created_by)['last_name']
                                }}
                            </td>
                        @else
                            <td>Not Set</td>
                        @endif

                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{$location->country ? $location->country->name : "N/A"}}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('State') }}</b></td>
                     <td>{{ $location->state ? $location->state->name :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('City') }}</b></td>
                     <td>{{ $location->city ? $location->city->name  :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Location') }}</b></td>
                     <td>{{ $location ? $location->location: "N/A"}}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Address') }}</b></td>
                     <td>{{ $location ? $location->address : "N/A"}}
                     </td>
                   </tr>

                                         
                    

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table> 
                 
  </div>
</div>
         </div>
        </div>
        
       
    </div>
@endsection