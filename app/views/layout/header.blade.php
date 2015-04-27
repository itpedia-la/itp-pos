<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="app_mode" content="rms">

<base href="{{ Config::get('app.url') }}">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/kendo.common.min.css" rel="stylesheet">
<link href="css/kendo.silver.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/kendo.all.min.js"></script>
<script src="js/main.js"></script>
<title>First May Group | Sale Report and Payment Tracking</title>
</head>

<!-- <style>
.k-window
    {
        box-shadow: none !important;
    }
.k-overlay { opacity:0.1 !important }
@media print
{
   body { display: none; }
}
</style> -->

<body>
	<div id="wrapper">
		@if( Auth::id() ) 
		<div id="header">
			<div class="floatLeft">
			<img src="img/logo.png" class="floatLeft" width="70">
			<div class="floatRight">
			<h3 style="padding:0px; margin:16px 0px 4px 5px; color:#070B97">First May Group Sole.,Ltd </h2>
			<h4 style="color:#ccc; margin:0px 0px 0px 5px; padding:0px">Sale Report and Payment Tracking</h4>
			</div>
			<div class="ClearFix"></div>
			</div>
			<div class="floatRight">
			ອັດຕາແລກປ່ຽນ ({{ Tool::toDate(ExchangeRate::orderBy('id','desc')->first()->created_at); }}): {{ ExchangeRate::orderBy('id','desc')->first()->USD; }} ฿ - {{ ExchangeRate::orderBy('id','desc')->first()->LAK; }} ₭
			</div>
			<div class="ClearFix"></div>
		</div>
		<ul id="menu">

			<!--<li><a href="{{ URL::to('transaction') }}"><span class="sprite invoice-16">&nbsp;</span> ຫນ້າຫລັກ</a></li> -->
			<li><a href="{{ URL::to('transaction') }}"><span class="sprite purchase-order-16">&nbsp;</span> ລາຍການຂາຍ (Transaction) </a></li>	
           
			<li><span class="sprite edit-property-16">&nbsp;</span> ບໍລິຫານຂໍ້ມູນ
				<ul>
					<li><a href="{{ URL::to('product') }}">ລາຍການ ສິນຄ້າ</a></li>
					<li><a href="{{ URL::to('service') }}">ລາຍການ ການບໍລິການ</a></li>
					<li><a href="{{ URL::to('customer') }}">ລາຍການ ລູກຄ້າ</a></li>
				</ul>
			</li>
			<li><span class="sprite area-chart-16">&nbsp;</span> ລາຍງານ
				<ul>
					<li><a href="{{ URL::to('report/delivery') }}/date/{{ date('01-m-Y') }}/{{ date('t-m-Y') }}">ລາຍລະອຽດ ການສົ່ງ (Delivery Report)</a></li>
					<li><a href="{{ URL::to('report/material/customer') }}/date/{{ date('01-m-Y') }}/{{ date('t-m-Y') }}">ການຜະລິດແຍກຕາມລູກຄ້າ (Material Report by Cust.)</a></li>
					<li><a href="{{ URL::to('report/transaction') }}/month/{{ date('F Y') }}">ລາຍລະອຽດ ການຂາຍ ແລະ ການຊຳລະເງິນ (Transaction and Payment Report)</a></li>
					<li><a href="{{ URL::to('report/service') }}/date/{{ date('01-m-Y') }}/{{ date('t-m-Y') }}">ລາຍລະອຽດ ການບໍລິການ (Service Report)</a></li>
					<!-- <li><a href="{{ URL::to('report/payment') }}/date/{{ date('01-m-Y') }}/{{ date('t-m-Y') }}">ລາຍລະອຽດ ໃບຮຽກເກັບເງິນ (Payment Report)</a></li> -->
				</ul>
			</li>	
			<li><span class="sprite gear-2-16">&nbsp;</span> ຕັ້ງຄ່າ
				<ul>
					<li id="liUserManage"><a href="{{ URL::to('user/list') }}">ຜູ້ໃຊ້ງານ</a></li>
					<li id="liExchangeRate"><a href="{{ URL::to('exchange') }}">ອັດຕາແລກປ່ຽນ</a></li>
					<li id="liApplicationSetting"><a href="{{ URL::to('profile') }}">ຕັ້ງຄ່າທົ່ວໄປ</a></li>
				</ul></li>

			<li style="float: right" class="k-primary"> <span class="sprite businessman-16-white">&nbsp;</span>  {{ Auth::user()->firstname }}
				<ul>
					<li><a href="{{ URL::to('user/personal/change/password') }}">ປ່ຽນລະຫັດຜ່ານ</a></li>
					<li><a href="{{ URL::to('user/logout') }}">ອອກຈາກລະບົບ</a></li>
				</ul>
				
				
			</li>
		</ul>
		@else
		<div style="margin:200px"></div>
		@endif