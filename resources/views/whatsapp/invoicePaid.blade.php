<!doctype html>
<html>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                       
            @if(isset($paid_invoice->invoice->user) && $paid_invoice->invoice->user->company_logo_url !='')
<img class="card-img-top" src="{{$paid_invoice->invoice->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; align-content: center;">
<br>
<p>{{$paid_invoice->invoice->user->company_detail ? $paid_invoice->invoice->user->company_detail->name : '' }}</p>
@endif
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                          <tr>
                            <td colspan="2">
                                Dear {{$paid_invoice->customer->name}},<br>
                                <em>
                                 This is to confirm receipt of the sum of <strong> N{{number_format($paid_invoice->amount_paid,2)}}</strong> for the <strong>{{$paid_invoice->invoice->prod ? $paid_invoice->invoice->prod->name : 'N/A'}}</strong> for <strong>{{ $paid_invoice->customer->name }}</strong>
                                 <br/>
                                  Please find details below;
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

<h4>Invoice payment DETAILS</h4>
        <table class="table table-bordered" id="rental_table">
           @if(isset($paid_invoice))
                    <tbody>
                     <tr>
                     <td style="width: 120px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $paid_invoice->invoice->prod ? $paid_invoice->invoice->prod->name : 'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Amount') }}</b></td>
                     <td>N{{ number_format($paid_invoice->invoice->billingAmount,2) }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Amount Paid') }}</b></td>
                     <!-- <td>&#8358;{{ number_format($paid_invoice->amount_paid,2) }} -->
                     <td>N{{ number_format($paid_invoice->invoice->amount_paid,2)}}
                     </td>
                   </tr>
                       <tr>
                     <td style="width: 120px;"><b>{{ __('Payment Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($paid_invoice->payment_date)) }}</td>           
              </tr>

                   <tr>
                     <td style="width: 120px;"><b>{{ __('Balance') }}</b></td>
                     <td>N{{ number_format($paid_invoice->billingbalance,2) }}
                     </td>
                   </tr>
                    

                   
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-dark">{{ $paid_invoice->invoice ? $paid_invoice->invoice->status : 'N/A' }}
                     </td>
                   </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>

                  <p>Thank you for your continued patronage.</p>
<p><b>{{$paid_invoice->invoice->user->company_detail ? $paid_invoice->invoice->user->company_detail->name : '' }}</b> Billing Team</p>
    </div>
</body>
</html>