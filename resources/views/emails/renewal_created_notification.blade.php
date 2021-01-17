<!DOCTYPE html>
<html lang="en" class="mail-html">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewal</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
      

    <style>
    .mail-html{background:#ffffff;} table{border-collapse:collapse;}
        .mail-body {width:80%; margin:100px auto; padding: 80px;font-family: "Century Gothic"; background:#ececec; box-shadow:2px 0 10px -5px rgba(0,0,0,0.3222);}
        .container{max-width:100%; padding:40px 30px; background:#ffffff;}.row{width:100%;} td{padding:5px} p, h3, h4, h5 {margin: 0} .no-margin{margin: 0px; padding: 0px;}
        .logo {margin-left: 0;} .date {margin-top: 50px;} td {text-align:left; margin-left: 20px;}  .table{border: 1px solid #383838;} .inc_width {width: 20%;}
        .total {float: right; margin-right: 200px;} .bordered-btm{border-bottom: 2px solid #818181;} .bordered{border: 1px solid #383838;} .small_font {font-size: 15px;}
        .info-table{width:100%;margin:45px 0 0 25px;} .info-table tr{border-bottom:1px solid #f4f4f4; background:#ffffff;} .info-table td{padding:7px 15px;} 
		.info-table td:nth-child(odd){width:180px; font-weight:600;} table.full{width:100%;} table.three-quarter{width:80%;} table h5.title{font-size:50px; font-weight:600; line-height:65px; color:#212121;} table h5.address{font-size: 15px;font-weight: 400;text-align: right;} table h6.sub-title{font-size:18px; font-weight:600;  line-height:28px; color:#212121; margin:5px 0; text-align:right;} .left-float{float:left;} .right-float{float:right;} .color-bg-black{background:#0000d9; color: #ffffff; font-size:14px;} .cust-address, .cust-info{font-size:14px;} .thead-dark{background:#383838;} .thead-dark *{color:#ffffff;} .thead-dark th, .thead-dark td{padding:15px; font-size:17px; text-align:left; border-left:1px solid #cfcfcf} .thead-dark th:first-child, .thead-dark td:first-child{border:none;} .table-content-wrap{padding:0 5px;} .table-content td{border-left:1px solid #383838; font-size:15px; line-height:18px; padding:5px 5px; border-bottom:1px solid #383838} .table-content td:first-child{border-left:none; border-bottom:1px solid #383838} table.tab td:first-child{width:calc(100% - 100px); font-weight:600; padding-right:40px;} table.tab td:nth-child(2){width:100px;} .text-right{text-align:right;} .info-table td{font-size:13px;} hr{border-color: #cfcfcf; margin: 40px 0; border-style: solid; border-width: 1px; border-top: 0px;} .gap-10{height:10px;} .gap-20{height:20px;} .gap-30{height:30px;} .gap-40{height:40px;}  .gap-50{height:50px;} .gap-60{height:60px;} .gap-70{height:70px;} .gap-80{height:80px;} .gap-90{height:90px;} .gap-100{height:100px;} .td-border{border-bottom:1px solid #383838;}
		@media (max-width:767px){
			td.nested {width:100% !important;}
			.mail-body{width: calc(100% - 60px); padding: 30px; display: inline-block;}
			.container, .row{position:relative; display:block; overflow:hidden;}
			/*table, tbody, thead, tr, td{display:inline-block; position:relative; width:100%;} table.intro td{width:50% !important;}*/
			table h5.title{font-size:38px; line-height:45px;}
			.logo{width:80px; max-width:80px;} table h6.sub-title {font-size: 16px; text-align: right; font-weight: 600;line-height: 21px;} table h5.address {font-size: 13px;}
			.intro-empty{width:25%;}
			.intro-info{width:80%;}
			.table-content-wrap{display:inline-block; width:100%; padding:0; overflow-x:scroll; overflow-y:hidden; }
			.info-table td:nth-child(odd) {width: 100px;} .hidden-small{display:none;} table.three-quarter {width: 100%;margin: 40px 0;}
			table.tab td:nth-child(2) {width: 100px; font-size: 14px; margin: 0; }
		}
        
    </style>
</head>
<body class="mail-body">
    <div class="container">
        <div class="row">
			<table class="intro full">
				<tr>
					<td><h5 class="title">INVOICE</h5></td>
					<td>
                        <a href="https://www.digitalwebglobal.com">
                            <img class="logo right-float" src="{{ asset('img/dwLogo.png') }}" alt="DW Logo"></td>
                        </a>
				</tr>
				<tr></tr>
			</table>
			<table class="intro full">
				<tr>
					<td class="intro-empty">&nbsp;</td>
					<td class="intro-info">
						<h6 class="sub-title"><strong>DigitalWeb Application Development Limited</strong></h6>
						<h5 class="address">34, Prince Alaba Abiodun, Oniru Street <br />Victoria Island, Lagos.</h5>
					</td>
				</tr>
			</table>
			<table class="intro full">
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td class="nested">
						<table class="bordered">
                            <tr>
                                <td class="color-bg-black"><strong>Sold To:</strong></td>
                                <td width="75%" class="td-border">  
									<strong>{{ $renewal->customers->name }}</strong><br />
									<span class="cust-address">{{ $renewal->customers->office_address }}</span>
								</td>
                            </tr>
                            
                            <tr>
                                <td class="color-bg-black"><strong>Date:</strong></td>
                                <td width="75%" class="cust-info td-border">{{ strftime('%d-%b-%Y', strtotime($renewal->created_at)) }}</td>
                            </tr>
                            <tr>
                                <td class="color-bg-black"><strong>Due Date:</strong></td>
                                <td width="75%" class="cust-info td-border">{{ strftime('%d-%b-%Y', strtotime($renewal->end_date)) }}</td>
                            </tr>
                        </table>
					</td>
					<td></td>
				</tr>
				<tr></tr>
			</table>
			
           
        </div>
        <br><br>
        <div class="row">
            <div class="table-content-wrap">
                <table class="table table-bordered full">
                    <thead class="thead-dark">
                        <tr>
                            <th width="80px">Category</th>
                            <th width="80px">Sub Category</th>
                            <th width="80px">Item</th>
                            <th width="100px">Qty</th>
                            <th>Description</th>
                            <th width="100px">Unit Cost</th>
                            <th width="100px">Extensions</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-content">
                     <td>{{ $renewal->category? $renewal->category->name:'N/A' }}</td>
                     <td>{{ $renewal->subcategory? $renewal->subcategory->name:'N/A' }}</td>
                      <td>{{ $renewal->prod? $renewal->prod->name:'N/A' }}</td>
                            <td>1</td>
                            <td>{{ $renewal->description }}</td>
                            <td>{{ number_format($renewal->billingAmount, 2) }}</td>
                            <td>0</td>
                        </tr>
						
                    </tbody>
                </table>				
            </div>
			<table class="tab full">
					<tr>
						<td class="text-right">Sub Total:</td>
						<td>{{ number_format($renewal->productPrice, 2) }}</td>
					</tr>
					<tr>
						<td class="text-right">Discount:</td>
						<td>{{ $renewal->discount }}%</td>
					</tr>
					<tr>
						<td class="text-right">Total:</td>
						<td>{{ number_format($renewal->billingAmount, 2) }}</td>
					</tr>
				</table>
        </div>
     
        <div class="row">
            <table class="full">
				<tr><td width="20%">&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td width="20%">&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td width="20%"><strong>Amount in words:</strong></td><td><strong><em> {{convertNumberToWord($renewal->billingAmount)}} naira only</em></strong></td></tr>

			</table>            
        </div>
		<hr />
		<div class="row">
            <table class="full">
				<tr><td>&nbsp;</td></tr>
				
				<tr><td><strong>Kindly raise check IFO Digitalweb Nigeria Limited or credit our Diamond Bank Account with following details</strong></td></tr>				
			</table>            
        </div>
        <div class="row">
                
			<table class="info-table three-quarter">
				<tr><td>Account Name  </td><td> Digitalweb Application Development Limited</td></tr>
				<tr><td>Bank Name   </td><td> Access (Diamond) Bank plc</td></tr>
				<tr><td>Branch </td><td> Plot 730 Adeola Hopewell Street, Victoria Island</td></tr>
				<tr><td>Sort Code </td><td> 063150269</td></tr>                        
				<tr><td>Account Number </td><td> 0044102222</td></tr>
			</table> 
        </div>
		<div class="row">
            <table class="full">
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>Thank you for always being our customer. Looking forward to always provide you with excellent services.</td></tr>				
			</table>            
        </div>
		<div class="row">
			<div class="gap-70"></div>
		</div>
    </div>
</body>
</html> 