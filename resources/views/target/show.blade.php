@extends('layouts.app', ['title' => __('Target Management'), 'icon' => 'las la-receipt'])
@section('content')
@include('users.partials.header', ['title' => __('View Target')])  


<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Target Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('target.sales.persons') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
        
                        </div>
                    </div>
                    <div class="card-body">
                                <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($target))
                    <tbody>
                         <tr>
                     <td style="width: 200px;"><b>{{ __('Sales Person') }}</b></td>
                     <td>{{ $target->salesPerson ? $target->salesPerson->name : '' }} {{ $target->salesPerson ? $target->salesPerson->last_name : '' }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Line Manager') }}</b></td>
                     <td>{{ $target->lineManager ? $target->lineManager->last_name : '' }}
                        {{ $target->lineManager ? $target->lineManager->last_name : '' }}
                     </td>
                   </tr>
                  <tr>
                     <td style="width: 200px;"><b>{{ __('Start Date') }}</b></td>
                <td>{{ $target->start_date ?  date("jS F, Y", strtotime($target->start_date)) : 'N/A' }}</td>           
              </tr>

                                  <tr>
                     <td style="width: 200px;"><b>{{ __('End Date') }}</b></td>
                <td>{{ $target->end_date ? date("jS F, Y", strtotime($target->end_date)) : 'N/A'}}</td>           
              </tr>

              <tr>
                     <td style="width: 200px;"><b>{{ __('Amount') }}</b></td>
                <td>&#8358;{{ number_format($target_amount, 2) }}</td>           
              </tr>

                <tr>
                     <td style="width: 200px;"><b>{{ __('Amount achieved ') }}</b></td>
                <td>&#8358;{{ number_format($salesPersoncloseWonOpportunitiesAmount,2)}}</td>           
              </tr>

               <tr>
                     <td style="width: 200px;"><b>{{ __('Percentage ') }}</b></td>
                <td>{{ isset($percentage_amount) ? $percentage_amount.'%' : 'N/A'}}</td>           
              </tr>
                    
                    </tbody>


                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                  <hr>
                   <div class="row">
    <div class="col-md-12">
         <h4 class="float-left">Products</h4>

                <a onclick="show_add_product_to_target_form()"  title="Add more product">
                    <button type="button" class="float-right btn btn-sm btn-primary" >
                <i class="fa fa-plus"></i>
                </button>
            </a>
    </div>
</div>
                    </div>
                     

                    <div class="table-responsive">
                                <table class="table align-items-center table-bordered datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Category') }}</th>
                                            <th scope="col">{{ __('Sub Category') }}</th>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Unit Price') }}</th>
                                            <th scope="col">{{ __('Quantity') }}</th>
                                            <th scope="col">{{ __('Amount') }}</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($target->products->isEmpty())
                                                <tr>
                                                    <td colspan="8" style="text-align: center">
                                                        <h3>No data available</h3>
                                                    </td>
                                                </tr>
                                        @else
                                            @foreach($target->products as $targetProd)
                                                <tr>
                                                        
                                                        <td>{{ $targetProd->category ? $targetProd->category->name : 'N/A' }}</td>
                                                        <td>{{ $targetProd->subcategory ? $targetProd->subcategory->name : 'N/A' }}</td>
                                                        <td>{{ $targetProd->product ? $targetProd->product->name : 'N/A' }}</td>

                                                        <td> &#8358;{{ $targetProd->unit_price ? number_format($targetProd->unit_price,2) : 'N/A' }}</td>
                                                        <td>{{ $targetProd->quantity ? $targetProd->quantity : 'N/A' }}</td>
                                                        <td> &#8358;{{ $targetProd->amount ? number_format($targetProd->amount,2) : 'N/A' }}</td>
                                                       
                                             
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>




                </div>
            </div>
        </div>
        
       
    @include('target.partials.add_nw_product')

        @include('layouts.footers.auth')

    </div>

@endsection

