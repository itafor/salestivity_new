@extends('layouts.app', ['title' => __('Recurring Management'), 'icon' => 'las la-file-invoice-dollar'])
@section('content')
@include('users.partials.header', ['title' => __('View Recurring')])  


<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Recurring') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-lef"></i></a>
                            </div>
                        </div>
                        <div class="row align-items-center">

                        
         @if(isset($renewal))
            <div class="col-8">
                @if($renewal->status == 'Paid')
            <a >
                <button class="btn btn-sm btn-success" id="pay">
            {{ __('Paid') }}
            </button>
        </a>
        @else
               <a onclick="renewalPayment({{$renewal->id}})" >
                <button class="btn btn-sm btn-primary" >
            {{ __('Payment') }}
            </button>
        </a>

        @endif

           @if($renewal->status == 'Paid' || $renewal->status == 'Partly paid')
            <a onclick="editPaidRenewalAlert()">
            <button class="btn btn-sm btn-primary" >
            {{ __('Edit') }}
            </button>
            </a>
            @else
            <a href="{{ route('billing.renewal.edit', ['id'=>$renewal->id]) }}">
            <button class="btn btn-sm btn-primary">
            {{ __('Edit') }}
            </button>
            </a>
            @endif 

             @if($renewal->status == 'Paid' || $renewal->status == 'Partly paid')
            <a onclick="deletePaidRenewalAlert()">
            <button class="btn btn-sm btn-danger" >
            {{ __('Delete') }}
            </button>
            </a>

              @else
             <a onclick="return confirm_delete()"  href="{{route('items.destroy',['renewal',$renewal->id])}}"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a>
              @endif

        <a  href="{{route('renewal.invoice.download',[$renewal->id])}}" >
                <button class="btn btn-sm btn-dark" >
            {{ __('Download Invoice') }}
            </button>
        </a>

         <a onclick="return confirm_invoice_payment_resend()" href="{{route('renewal.invoice.resend',[$renewal->id])}}"><button class="btn btn-sm btn-default">{{ __('Resend Invoice') }}</button></a>
            </div>
            @endif
                        </div>
                    </div>


                    <div class="card-body">
                                <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($renewal))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Invoice Number') }}</b></td>
                     <td>{{ $renewal->invoice_number ? $renewal->invoice_number : 'N/A' }}</td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Bill Status') }}</b></td>
                     <td>

                        {{ $renewal->bill_status ? $renewal->bill_status : 'N/A' }}
                        &nbsp;&nbsp;&nbsp;&nbsp;
             
              <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Change Bill Status
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a onclick="return confirm_delete()" class="dropdown-item" href="{{route('recurring.bill.status.sent',[$renewal->id])}}">Sent</a>
                    <a onclick="return confirm_delete()" class="dropdown-item" href="{{route('recurring.bill.status.confirm',[$renewal->id])}}">Confirmed</a>
                  </div>
                </div>

                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $renewal->customers ? $renewal->customers->name : 'N/A' }}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Email') }}</b></td>
                     <td>{{ $renewal->customers ? $renewal->customers->email : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Phone') }}</b></td>
                     <td>{{ $renewal->customers ? $renewal->customers->phone : 'N/A' }}</td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Category') }}</b></td>
                     <td>{{ $renewal->category? $renewal->category->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Sub Category') }}</b></td>
                     <td>{{ $renewal->subcategory? $renewal->subcategory->name:'N/A' }}
                     </td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $renewal->prod? $renewal->prod->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td>&#8358;{{ number_format($renewal->productPrice,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Discount') }}</b></td>
                     <td>
                        {{ $renewal->discount == '' ? 'N/A' : $renewal->discount.'%'}} 
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Amount') }}</b></td>
                     <td>&#8358;{{ number_format($renewal->billingAmount,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Amount Paid') }}</b></td>
                     <td>&#8358;{{ number_format($renewal->amount_paid,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Balance') }}</b></td>
                     <td>&#8358;{{ number_format($renewal->billingBalance,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Discription') }}</b></td>
                     <td>{{ $renewal->description }}
                     </td>
                   </tr>

                    @if($renewal->status == 'Paid')
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Payment Status') }}</b></td>
                     <td class="text-success">{{ $renewal->status }}
                     </td>
                   </tr>
                    @elseif($renewal->status == 'Partly paid')
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Payment Status') }}</b></td>
                     <td class="text-warning">
                        {{ $renewal->status }}
                     </td>
                   </tr>
                     @else
                      <tr>
                     <td style="width: 200px;"><b>{{ __('Payment Status') }}</b></td>
                     <td class="text-danger">
                         {{ $renewal->status }}
                     </td>
                   </tr>
                     @endif

                 

                <tr>
                     <td style="width: 200px;"><b>{{ __('Start Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->start_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 200px;"><b>{{ __('End Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->end_date)) }}</td>           
              </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Duration Type') }}</b></td>
                <td>{{ $renewal->duration_type ? $renewal->duration_type : 'N/A' }}</td>           
              </tr>

               <tr>
                 <td style="width: 200px;"><b>{{ __('Reminder Durations') }}</b></td>
                 <td> First : {{$renewal->duration ? $renewal->duration->first_duration.'days' : 'N/A' }}, Second: {{$renewal->duration ? $renewal->duration->second_duration.'days' : 'N/A' }}, Third: {{$renewal->duration ? $renewal->duration->third_duration.'days' : 'N/A' }} </td>
                 </tr>

                 <tr>
                     <td style="width: 200px;"><b>{{ __('Delivery Email') }}</b></td>
                <td>{{ $renewal->compEmail ? $renewal->compEmail->email : 'N/A' }}</td>           
              </tr>
              <tr>
                 <td style="width: 200px;"><b>{{ __('Bank Account') }}</b></td>
                 <td> <strong>Bank</strong> : {{$renewal->compBankAcct ? $renewal->compBankAcct->bank_name : 'N/A' }}, <strong>Account Name</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->account_name : 'N/A' }}, <strong>Account Number</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->account_number : 'N/A' }} </td>
                 </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                    </div>
                     @if($renewalPayments !='')
                    @include('billing.renewal.payment.show')
                      @endif
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
       
    @include('billing.renewal.payment.create')

    </div>

@endsection