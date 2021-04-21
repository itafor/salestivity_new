@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])
@section('content')
@include('users.partials.header', ['title' => __('View Invoice')])  


<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Invoice') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.invoice.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                       
         @if(isset($invoice))
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


            <!--  @if($invoice->status == 'Paid' || $invoice->status == 'Partly paid')
            <a onclick="editPaidinvoiceAlert()">
            <button class="btn btn-sm btn-primary" >
            {{ __('Edit') }}
            </button>
            </a>
            @else
            <a href="{{ route('billing.invoice.edit', ['id'=>$invoice->id]) }}">
            <button class="btn btn-sm btn-primary">
            {{ __('Edit') }}
            </button>
            </a>
            @endif -->

          

              @if($invoice->status == 'Paid' || $invoice->status == 'Partly paid')
               <a onclick="deletePaidinvoiceAlert()">
            <button class="btn btn-sm btn-danger" >
            {{ __('Delete') }}
            </button>
            </a>
                @else
             <a onclick="return confirm_delete()" href="{{route('items.destroy',['invoice',$invoice->id])}}"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a>
              @endif

                <a  href="{{route('invoice.download',[$invoice->id])}}" >
                <button class="btn btn-sm btn-dark" >
            {{ __('Download Invoice') }}
            </button>
        </a>

         <a onclick="return confirm_invoice_payment_resend()" href="{{route('invoice.payment.resend',[$invoice->id])}}"><button class="btn btn-sm btn-default">{{ __('Resend Invoice') }}</button></a>
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