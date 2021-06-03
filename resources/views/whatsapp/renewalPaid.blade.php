<!doctype html>
<html>
<head>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>

             @if(isset($renewal->user) && $renewal->user->company_logo_url !='')
<img class="card-img-top" src="{{$renewal->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px;  align-content: center;">
<br>
<span style="margin: auto;"><b>{{$renewal->user->company_detail ? $renewal->user->company_detail->name : '' }}</b></span>
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
                                Dear {{$renewal->customer->name}},<br>
                                <em>
                                 This is to confirm receipt of the sum of <strong>N {{number_format($renewal->amount_paid,2)}}</strong> for the <strong>{{$renewal->product->name}}</strong> for <strong>{{ $renewal->customer->name }}</strong>
                                 <br/>
                                  Please find details below;
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table table-bordered" id="rental_table">
           @if(isset($renewal))
                    <tbody>
                   

                     <tr>
                     <td style="width: 120px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $renewal->renewal->prod ? $renewal->renewal->prod->name : 'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Amount') }}</b></td>
                     <td>N{{ number_format($renewal->renewal->billingAmount,2) }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Amount Paid') }}</b></td>
                     <td>N{{ number_format($renewal->renewal->amount_paid,2) }}
                     </td>
                   </tr>
                      <tr>
                     <td style="width: 120px;"><b>{{ __('Payment Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->payment_date)) }}</td>           
              </tr>

                   <tr>
                     <td style="width: 120px;"><b>{{ __('Balance') }}</b></td>
                     <td>N{{ number_format($renewal->billingbalance,2) }}
                     </td>
                   </tr>
                    

                    @if($payment_status->status == 'Paid')
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-success">{{ $payment_status->status }}
                     </td>
                   </tr>
                    @elseif($payment_status->status == 'Partly paid')
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-warning">
                        {{ $payment_status->status }}
                     </td>
                   </tr>
                     @else
                      <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-danger">
                         {{ $payment_status->status }}
                     </td>
                   </tr>
                     @endif

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>

<p>Thank you for your continued patronage.</p>
<p><b>{{$renewal->user->company_detail ? $renewal->user->company_detail->name : '' }}</b> Billing Team</p>
         

    </div>
</body>
</html>