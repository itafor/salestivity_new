@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-user'])
@section('content')
@include('users.partials.header', ['title' => __(' Customer Details')])  


<script>
        $(document).ready(function(){
            /*Disable all input type="text" box*/
            $('#form1 input').prop("disabled", true);
            $('#pay').prop("disabled", true);
            $('#form1 button').hide();

            $('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 select').prop("disabled", false);
            $('#form1 button').show();
            $('#title').html('Edit Renewal');
            $('#edit').toggle();
            })
            
        });
    </script> 

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                   <div class="card-header col-12">
                        <div class="row">
                            <div class="col-6  text-left">
                               <h3 class="mb-0 float-left" id="title">{{ __('Customers') }}</h3>
                            </div>
                            <div class="col-6  text-right">
                              @if(isset($customer))
                                <a href="{{ route('customer.edit', ['id'=>$customer->id]) }}" class="btn-icon btn-tooltip" title="{{ __('Edit') }}"><i class="las la-user-edit"></i></a>

                                <a onclick="deleteData('customer','destroy',{{$customer->id}})" class="btn-icon btn-tooltip" title="{{ __('Delete') }}"><i class="las la-trash"></i></a>
                              @endif
                               
                                <a href="{{ route('customer.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    

                    <div class="card-body">
                                <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($customer))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $customer->name }}</td>
                   </tr>
                     <tr>
                     <td style="width: 200px;"><b>{{ __('Customer ID') }}</b></td>
                     <td>{{ $customer->customer_id ? $customer->customer_id : 'N/A'}}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Email') }}</b></td>
                     <td>{{ $customer->email }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Phone') }}</b></td>
                     <td>{{ $customer->phone }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Website') }}</b></td>
                     <td>{{ $customer->website }}</td>
                   </tr>
                  
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Industry') }}</b></td>
                     <td>{{ $customer->customerIndustry->name ?? '' }}</td>
                   </tr>
                   @if($customer->customer_type == 'Corporate')
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Turn Over') }}</b></td>
                     <td>{{ $customer->turn_over }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Employee Count') }}</b></td>
                     <td>{{ $customer->employee_count }}</td>
                   </tr>
                   @endif
                   <tr>
                   <td style="width: 200px;"><b>{{ __('Author') }}</b></td>
                      @if(getCreatedByDetails($customer->user_type, $customer->created_by) !== null)
                        <td>{{ getCreatedByDetails($customer->user_type, $customer->created_by)['name'] .' '.
                            getCreatedByDetails($customer->user_type, $customer->created_by)['last_name']
                            }}
                        </td>
                    @else
                        <td>Not Set</td>
                    @endif
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Customer Type') }}</b></td>
                     <td>{{ $customer->customer_type }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Country') }}</b></td>
                     <td>{{ $customer->address->countryName->name ?? "" }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('State') }}</b></td>
                     <td>{{ $customer->address->stateName->name ?? '' }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('City') }}</b></td>
                     <td>{{ $customer->address->cityName->name ?? '' }}</td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Street Address') }}</b></td>
                     <td>{{ $customer->address->street ?? '' }}</td>
                   </tr>
                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>

                  @if($contacts !='')
                  <div class="row mt-30 mb-30">
                      <div class="col-md-12">
                        @include('customer.contact.show')
                      </div>
                  </div>
                      @endif
                    </div>
                      
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
       
   

    </div>

@endsection