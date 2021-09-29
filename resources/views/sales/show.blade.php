@extends('layouts.app', ['title' => __('Sales Management'), 'icon' => 'las la-calculator'])
@section('content')
@include('users.partials.header', ['title' => __('Add Sales')])


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
              <a href="{{route('sales.edit',[$sale->id])}}" class="btn-icon btn-tooltip" title="{{ __('Edit') }}"><i class="las la-edit"></i></a>
              <a href="{{ route('sales.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
          </div>
      </div>
    </div>

  <div class="card-body">
             <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($sale))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Category') }}</b></td>
                     <td>{{$sale->category ? $sale->category->name : "N/A"}}</td>
                   </tr>
                     <tr>
                     <td style="width: 200px;"><b>{{ __('Sub Category') }}</b></td>
                     <td>{{$sale->subcategory ? $sale->subcategory->name : "N/A"}}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $sale->products ? $sale->products->name :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Quantity') }}</b></td>
                     <td>{{ $sale->quantity ? $sale->quantity :'N/A' }}</td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td>{{ $sale->price ? $sale->price :'N/A' }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Total Amount') }}</b></td>
                     <td>{{ $sale->total_amount ? $sale->total_amount :'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Sales Person') }}</b></td>
                     <td>{{ $sale->salesPerson ? $sale->salesPerson->name.' '.$sale->salesPerson->last_name :'N/A' }}</td>
                   </tr>
                     <tr>
                     <td style="width: 200px;"><b>{{ __('Location') }}</b></td>
                     <td>{{ $sale->location ? $sale->location->location :'N/A' }}</td>
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
        
        @include('layouts.footers.auth')
    </div>


@endsection