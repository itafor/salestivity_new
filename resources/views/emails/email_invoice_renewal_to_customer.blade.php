<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Renewal Notification</title>
    
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
       <h2>Invoice Renewal Notification</h2>

<div class="card">

  <div class="card-body">

     @if(isset($renewal->user) && $renewal->user->company_logo_url !='')
<img class="card-img-top" src="{{$renewal->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; border-radius: 50px; align-content: center;">
@endif

    <p class="card-text">Dear {{$renewal->customers->name}},</p>
    <p>Please be informed that for the <strong>{{ $renewal->prod ? $renewal->prod->name : 'N/A' }}</strong> for <strong>{{ $renewal->customers->name }}</strong> is due for renewal.</p>
<p>
Find below the details of the invoice. Kindly make payment before the due date to avoid service suspension. Please read the domain expiration information section below.
</p>
<h4>Invoice Details</h4>
<table class="table table-bordered" id="rental_table">
@if(isset($renewal))
<tbody>
<tr>
<td style="width: 150px;"><b>{{ __('Customer') }}</b></td>
<td>{{ $renewal->customers->name }}</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Item') }}</b></td>
<td>{{ $renewal->prod ? $renewal->prod->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Invoice Number') }}</b></td>
<td>{{ $renewal->invoice_number ? $renewal->invoice_number : 'N/A' }}<td>
</td>
</tr>
@if($renewal->status == 'Paid')
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-success">{{ $renewal->status }}
</td>
</tr>
@elseif($renewal->status == 'Partly paid')
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-warning">
{{ $renewal->status }}
</td>
</tr>
@else
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-danger">
{{ $renewal->status }}
</td>
</tr>
@endif
<tr>
<td style="width: 150px;"><b>{{ __('Amount Due') }}</b></td>
<td>&#8358;{{ number_format($renewal->billingBalance,2) }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Payment Method') }}</b></td>
<td>Bank Transfer 
Digitalweb Application Development Limited
0044102222
Access Bank
</td>           
</tr>
</tbody>
@else
<span>No matching records found</span>
@endif
</table>
<p>Thank you for your continuous patronage.<br>
Digitalweb Billing Team</p><br>
<p>Important Domain Expiration Information
Please note after the due date your domain name, website alongside emails and other services will stop working. Please endeavour to make payments before this date to avoid service interruptions.
</p>
<p>
Also note that when your domain expires without renewing, it enters a Grace Period of about 29 - 35 days within which renewals can be made with an additional $50.00 to the fees stated above.
</p>
<p>
After this period, if your domain is not renewed, it enters a Redemtion Grace Period. A period of another 42 days where the owner can claim the domain with additional $200 redemption fee.
</p>
<p>
After this period, your domain may now be released to the public for re-registration on a first come first served basis or may be *AUCTIONED OFF** to the highest bidder in a domain auction system.
</p>
<p>
To avoid losing your domain name to an auction or anybody else, ensure your domain name is renewed and is always active.
</p>
<p>
This invoice and the details specified is generated for the client or organization whose names appear on it. If you have received this invoice in error, kindly disregard the information and delete as appropriate.
</p>
  </div>
</div>
    </div>
</body>
</html>