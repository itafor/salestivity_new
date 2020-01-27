@extends('layouts.app', ['title' => __('Add Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('View Renewal')])  


<script>
        $(document).ready(function(){
            /*Disable all input type="text" box*/
            $('#form1 input').prop("disabled", true);
            $('#form1 select').prop("disabled", true);
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
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0" id="title">{{ __('Renewal') }}</h3>
                            </div>
            <div class="col-4 text-right">
            <a onclick="renewalPayment({{$renewal->id}})">
                <button class="btn btn-sm btn-success">
            {{ __('Payment') }}
            </button>
        </a>

            <a href="{{ route('billing.renewal.edit', ['id'=>$renewal->id]) }}">
            <button class="btn btn-sm btn-primary">
            {{ __('Edit') }}
            </button>
            </a>
            
             <a onclick="return confirm('Are you sure?')" href="{{ route('billing.renewal.destroy', [$renewal->id]) }}" class="btn btn-sm btn-danger">{{ __('Delete') }}</a>

            <a href="{{ route('billing.renewal.index') }}"><button id="edit" class="btn btn-sm btn-primary">{{ __('Back to list') }} </button></a>


            </div>
                        </div>
                    </div>
                    <div class="card-body">
                                <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($renewal))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $renewal->customers->name }}</td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $renewal->product_name? $renewal->product_name->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td>&#8358;{{ number_format($renewal->productPrice,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Discount') }}</b></td>
                     <td>{{ $renewal->discount }} %
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Amount') }}</b></td>
                     <td>&#8358;{{ number_format($renewal->billingAmount,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Discription') }}</b></td>
                     <td>{{ $renewal->description }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td>{{ $renewal->status }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Start Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->start_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;"><b>{{ __('End Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->end_date)) }}</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                    </div>
                    @include('billing.renewal.payment.show')
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    @include('billing.renewal.payment.create')

    </div>

@endsection