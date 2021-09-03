<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice Notification</title>

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
<h2>Invoice Receipt Confirmation</h2>

<div class="card">

<div class="card-body">

@if(isset($invoice->user) && $invoice->user->company_logo_url !='')
<img class="card-img-top" src="{{$invoice->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; align-content: center;">
<p>{{$invoice->user->company_detail ? $invoice->user->company_detail->name : '' }}</p>
@endif

<p class="card-text">Dear {{$invoice->user->name}} {{$invoice->user->last_name}},</p>
<p>
This is to inform you that the Invoice with Invoice Number <b>{{$invoice->invoice_number}}</b> has been confirmed by the recipient.
</p>
<p>
	@if(isset($invoice))
              <?php   
            $currentStatus= invoicePaymentStatus($invoice);
              ?>

Please click <a href="{{ route('billing.invoice.show', [$invoice->id, $currentStatus, 'next']) }}">HERE</a> to view invoice details
</p>
@endif
Thanks.

</div>
</div>
</div>
</body>
</html>