<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recurring Payment Notifications</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
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
<!--                     <table>
                        <tr>
                       
                            <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/companydefaultlogo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="40" >
                            </a> 
                            
                            
                            <td style="text-align:right">
                                
                            </td>
                        </tr>
                    </table> -->
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                          <tr>
                            <td colspan="2">
                                Dear {{$paid_invoice->customer->name}},<br>
                                <em>
                                  We wish to inform you that the sum of <strong>&#8358;{{number_format($paid_invoice->amount_paid,2)}}</strong> has been recorded for the payment of <strong>{{$paid_invoice->product->name}}</strong>
                                 <br/>
                                  Please find below Recurring details.
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
                     <td style="width: 120px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $paid_invoice->customer->name }}</td>
                   </tr>

                     <tr>
                     <td style="width: 120px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $paid_invoice->product? $paid_invoice->product->name:'N/A' }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Billing Amount') }}</b></td>
                     <td>&#8358;{{ number_format($paid_invoice->billingAmount,2) }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Amount Paid') }}</b></td>
                     <td>&#8358;{{ number_format($paid_invoice->amount_paid,2) }}
                     </td>
                   </tr>

                   <tr>
                     <td style="width: 120px;"><b>{{ __('Billing Balance') }}</b></td>
                     <td>&#8358;{{ number_format($paid_invoice->billingbalance,2) }}
                     </td>
                   </tr>
                    

                    @if($paid_invoice->status == 'Paid')
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-success">{{ $paid_invoice->status }}
                     </td>
                   </tr>
                    @elseif($paid_invoice->status == 'Partly paid')
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-warning">
                        {{ $paid_invoice->status }}
                     </td>
                   </tr>
                     @else
                      <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-danger">
                         {{ $paid_invoice->status }}
                     </td>
                   </tr>
                     @endif

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Payment Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($paid_invoice->payment_date)) }}</td>           
              </tr>
              <tr>
                     <td style="width: 120px;"><b>{{ __('Date Recorded') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($paid_invoice->created_at)) }}</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>


         

    </div>
</body>
</html>