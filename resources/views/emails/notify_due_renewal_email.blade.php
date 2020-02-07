<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Renewal Payment Notifications</title>
    
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
                              Dear {{$customerContact->name}},<br>
                                <em>
                                    @if($remaing_days == 0)
                            Kindly be notified that your renewal has expired.<br>
                                   
                               Expired Date: ( {{ date("jS F, Y", strtotime($customerRenewal->end_date)) }} )
                                    
                                    @else
                                   
                                   Kindly be notified that your renewal will be due in {{$remaing_days}} {{$remaing_days > 1 ? 'days' : 'day'}}
                                   
                                 ( {{ date("jS F, Y", strtotime($customerRenewal->end_date)) }} )

                                 @endif
                                 <br/>
                                  Please find below renewal details.
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

<h4>Renewal DETAILS</h4>
        <table class="table table-bordered" id="rental_table">
           @if(isset($customerRenewal))
                    <tbody>
                   <tr>
                     <td style="width: 120px;"><b>{{ __('Customer') }}</b></td>
                     <td>{{ $customerRenewal->customers->name }}</td>
                   </tr>

                     <tr>
                     <td style="width: 120px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $customerRenewal->product_name? $customerRenewal->product_name->name:'N/A' }}
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Billing Amount') }}</b></td>
                     <td>&#8358;{{ number_format($customerRenewal->billingAmount,2) }}
                     </td>
                   </tr>

                    <tr>
                     <td style="width: 120px;"><b>{{ __('Billing Balance') }}</b></td>
                     <td>&#8358;{{ number_format($customerRenewal->billingBalance,2) }}
                     </td>
                   </tr>
                    

                    @if($customerRenewal->status == 'Paid')
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-success">{{ $customerRenewal->status }}
                     </td>
                   </tr>
                    @elseif($customerRenewal->status == 'Partly paid')
                    <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-warning">
                        {{ $customerRenewal->status }}
                     </td>
                   </tr>
                     @else
                      <tr>
                     <td style="width: 120px;"><b>{{ __('Status') }}</b></td>
                     <td class="text-danger">
                         {{ $customerRenewal->status }}
                     </td>
                   </tr>
                     @endif

                
              <tr>
                     <td style="width: 120px;"><b>{{ __('Start Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($customerRenewal->start_date)) }}</td>           
              </tr>

              <tr>
                     <td style="width: 120px;"><b>{{ __('End Date') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($customerRenewal->end_date)) }}</td>           
              </tr>

              <tr>
                     <td style="width: 120px;"><b>{{ __('Days left') }}</b></td>
                <td>{{$remaing_days}} {{$remaing_days > 1 ? 'days' : 'day'}}</td>           
              </tr>

              <tr>
                     <td style="width: 120px;"><b>{{ __('Date created') }}</b></td>
                <td>{{ date("jS F, Y", strtotime($customerRenewal->created_at)) }}</td>           
              </tr>

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>


         

    </div>
</body>
</html>