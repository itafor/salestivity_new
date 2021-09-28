@extends('layouts.app', ['title' => __('Project Management'), 'icon' => 'las la-gem' ])
@section('content')
@include('users.partials.header', ['title' => __('Project Management')])  



<div class="container-fluid mt--7">
        <div class="row">
<div class="col-xl-12 order-xl-1">
  <div class="card shadow">
  

    <div class="card-header bg-white">
      <div class="row align-items-center">
          <div class="col-8">
              <h3 class="mb-0">{{ __('Project Details') }}</h3>
          </div>
          <div class="col-4 text-right">
              <a href="{{route('project.edit',[$project->id])}}" class="btn-icon btn-tooltip" title="{{ __('Edit') }}"><i class="las la-edit"></i></a>
              <a href="{{ route('project.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
          </div>
      </div>
    </div>


  <div class="card-body">
             <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($project))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{$project->customer ? $project->customer->name : "N/A"}}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $project->product ? $project->product->name :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('technician') }}</b></td>
                     <td>{{ $project->getTechnician ? $project->getTechnician->name .' '.$project->getTechnician->last_name :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Note') }}</b></td>
                     <td>{{ $project->notes ? $project->notes: "N/A"}}
                     </td>
                   </tr>

                                         
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td>{!! $project->status ? $project->status : 'N/A'  !!}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __(' Date Created') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($project->created_at)) }}</td>           
              </tr>


                    <tr>
                     <td style="width: 200px;"><b>{{ __('Start Date') }}</b></td>
<td>{{ strftime('%d-%b-%Y', strtotime($project->start_date)) }}</td>
                    
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('End Date') }}</b></td>
<td>{{ strftime('%d-%b-%Y', strtotime($project->end_date)) }}</td>
                    
                   </tr>
                         
             

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table> 
                  <hr>
                  <h2>Photo</h2>
                  @if($project->uploads)
                  <img src="{{$project->uploads}}" alt="Photo" width="100" height="100">
                  @else
                  <span>No photo</span>
                  @endif
  </div>
</div>
         </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>





@endsection