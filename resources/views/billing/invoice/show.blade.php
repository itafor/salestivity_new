@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])
@section('content')
@include('users.partials.header', ['title' => __('View Invoice')])  


<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
 <div class="row align-items-center">


@if(isset($invoice))
                              <?php   
                            $currentStatus= "";
                            if(isset($invoice)){
                            if($invoice->status == 'Partly paid'){
                            $currentStatus = "partly_paid";
                            }elseif($invoice->status == 'Pending'){
                            $currentStatus = "outstanding";
                            }elseif($invoice->status == 'Paid'){
                            $currentStatus = "paid";
                            }else{
                            $currentStatus = "all";
                            }
                            }
                            ?>
                         <div class="col-6">
                                 <a href="{{ route('billing.invoice.show', [$invoice->id, $currentStatus, 'previous']) }}" title="Previous {{$currentStatus}} Invoice">
                                <button class="btn btn-default btn-sm float-left"
                                {{isset($minId) && $minId == $currentId ? "disabled" : "" }} ><i class="fa fa-arrow-left" aria-hidden="true"></i></button>

                                 </a>

                                  <a href="{{ route('billing.invoice.show', [$invoice->id, $currentStatus, 'next']) }}"  title="Next {{$currentStatus}} Invoice">                        

                                    <button class="btn btn-default btn-sm float-right"
                                    {{isset($maxId) && $maxId == $currentId ? "disabled" : "" }}><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                 </a>

                            </div>
                       
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Invoice') }}</h3>
                            </div>
        


                            <div class="col-4 text-right">
                                <a href="{{ route('billing.invoice.view',[$currentStatus]) }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                       
       
            <div class="col-8">
                @if($invoice->status == 'Paid')
            <a >
                <button class="btn btn-sm btn-success" id="pay">
            {{ __('Paid') }}
            </button>
        </a>
        @else
               <a onclick="invoice_payment({{$invoice->id}})" >
                <button class="btn btn-sm btn-primary" >
            {{ __('Payment') }}
            </button>
        </a>

        @endif


            <!-- <a href="{{ route('billing.invoice.edit', ['id'=>$invoice->id]) }}">
            <button class="btn btn-sm btn-primary">
            {{ __('Edit') }}
            </button>
            </a> -->
            

          

             
             <a onclick="return confirm_delete()" href="{{route('items.destroy',['invoice',$invoice->id])}}"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a>
            

                <a  href="{{route('invoice.download',[$invoice->id])}}" >
                <button class="btn btn-sm btn-dark" >
            {{ __('Download Invoice') }}
            </button>
        </a>

         <a onclick="return confirm_invoice_payment_resend()" href="{{route('invoice.payment.resend',[$invoice->id])}}"><button class="btn btn-sm btn-success">{{ __('Resend Invoice') }}</button></a>
            </div>
            @endif
                        </div>
                    </div>
                    <div class="card-body">
                                <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($invoice))


                    <tbody>
                         <tr>
                     <td style="width: 200px;"><b>{{ __('Invoice Number') }}</b></td>
                     <td>{{ $invoice->invoice_number ? $invoice->invoice_number : 'N/A' }}</td>
                   </tr>
                     <tr>
                     <td style="width: 200px;"><b>{{ __('Bill Status') }}</b></td>
                     <td>

                        {{ $invoice->bill_status ? $invoice->bill_status : 'N/A' }}
                        &nbsp;&nbsp;&nbsp;&nbsp;
             
              <div class="dropdown">
                  <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b>Change Bill Status</b>
                  </span>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a onclick="return confirm_delete()" class="dropdown-item" href="{{route('invoice.bill.status.sent',[$invoice->id])}}">Sent</a>
                    <a onclick="return confirm_delete()" class="dropdown-item" href="{{route('invoice.bill.status.confirm',[$invoice->id])}}">Confirmed</a>
                  </div>
                </div>

                     </td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $invoice->customers ? $invoice->customers->name : 'N/A' }}</td>
                   </tr>
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Email') }}</b></td>
                     <td>{{ $invoice->customers ? $invoice->customers->email : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Phone') }}</b></td>
                     <td>{{ $invoice->customers ? $invoice->customers->phone : 'N/A' }}</td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Category') }}</b></td>
                     <td>{{ $invoice->category? $invoice->category->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Sub Category') }}</b></td>
                     <td>{{ $invoice->subcategory? $invoice->subcategory->name:'N/A' }}
                     </td>
                   </tr>

                     <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $invoice->prod? $invoice->prod->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Price') }}</b></td>
                     <td>&#8358;{{ number_format($invoice->cost,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Discount') }}</b></td>
                     <td>
                        {{ $invoice->discount == '' ? 'N/A' : $invoice->discount.'%'}} 
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Amount') }}</b></td>
                     <td>&#8358;{{ number_format($invoice->billingAmount,2) }}
                     </td>
                   </tr>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Amount Paid') }}</b></td>
                     <td>&#8358;{{ number_format($invoice->amount_paid,2) }}
                     </td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Billing Balance') }}</b></td>
                     <td>&#8358;{{ number_format($invoice->billingBalance,2) }}
                     </td>
                   </tr>
                   

                    @if($invoice->status == 'Paid')
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-success">{{ $invoice->status }}
                     </td>
                   </tr>
                    @elseif($invoice->status == 'Partly paid')
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-warning">
                        {{ $invoice->status }}
                     </td>
                   </tr>
                     @else
                      <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-danger">
                         {{ $invoice->status }}
                     </td>
                   </tr>
                     @endif
                      <tr>
                     <td style="width: 200px;"><b>{{ __('Delivery Email') }}</b></td>
                <td>{{ $invoice->compEmail ? $invoice->compEmail->email : 'N/A' }}</td>           
              </tr>
              <tr>
                 <td style="width: 200px;"><b>{{ __('Bank Account') }}</b></td>
                 <td> <strong>Bank</strong> : {{$invoice->compBankAcct ? $invoice->compBankAcct->bank_name : 'N/A' }}, <strong>Account Name</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_name : 'N/A' }}, <strong>Account Number</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_number : 'N/A' }} </td>
                 </tr>
                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                    </div>
                     @if($invoice->invoicePayment !='')
                    @include('billing.invoice.payment.show')
                      @endif
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
       
    @include('billing.invoice.payment.create')

    </div>

@endsection