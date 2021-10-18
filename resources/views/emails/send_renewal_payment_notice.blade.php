<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation of Payment</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        /*border: 1px solid #eee;*/
        /*box-shadow: 0 0 10px rgba(0, 0, 0, .15);*/
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    #rental_table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

#rental_table td{
  border: 1px solid #ddd;
  padding: 8px;
}
#rental_table .rent_title{
  width: 150px;
}

.logo_name{
    float: right;
}

.receipt_title{
    float: left;
}

    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        .notification_header{
            font-size: 10px;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>

 
                           
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                   
                </td>
            </tr>
        </table>
<div class="logo_name">
                    @if(isset($renewal->user) && $renewal->user->company_logo_url !='')
<img class="card-img-top" src="{{$renewal->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px;  align-content: center;">
<br>

@endif

@if(isset($renewal->user))
<p><b>{{getCompanyName($renewal->user) }}</b></p>
@endif
</div>
<table>
  <tr>
    <td colspan="2">
        Dear {{$renewal->customer->name}},<br>
        <em>
         This is to confirm receipt of the sum of <strong>{!! $renewal->product && $renewal->product->currency ? $renewal->product->currency->symbol : '&#8358;' !!}
            {{number_format($renewal->amount_paid,2)}}</strong> for the <strong>{{$renewal->product->name}}</strong> for <strong>{{ $renewal->customer->name }}</strong>
         <br/>
          Please find details below;
        </em>
    </td>
</tr>
</table>
<div class="row receipt_title">
 <div class="col-4" style="float: left;">
              <h3 >Receipt</h3>
          </div>
          <div class="col-8" style="float: right; margin-left: 400px;">
            <b>Invoiced to:</b> {{$renewal->customer->name}}
          </div>
      </div>
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
                     <td>{!! $renewal->product && $renewal->product->currency ? $renewal->product->currency->symbol : '&#8358;' !!}{{ number_format($renewal->renewal->billingAmount,2) }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Amount Paid') }}</b></td>
                     <td>{!! $renewal->product && $renewal->product->currency ? $renewal->product->currency->symbol : '&#8358;' !!}{{ number_format($renewal->renewal->amount_paid,2) }}
                     </td>
                   </tr>
                      <tr>
                     <td style="width: 120px;"><b>{{ __('Payment Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($renewal->payment_date)) }}</td>           
              </tr>

                   <tr>
                     <td style="width: 120px;"><b>{{ __('Balance') }}</b></td>
                     <td>{!! $renewal->product && $renewal->product->currency ? $renewal->product->currency->symbol : '&#8358;' !!}{{ number_format($renewal->billingbalance,2) }}
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
<p><b>
    @if(isset($renewal->user))
{{getCompanyName($renewal->user) }}
@endif
</b> Billing Team</p>
         

    </div>
</body>
</html>