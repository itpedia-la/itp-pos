<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>ລາຍງານ - ລາຍລະອຽດການສົ່ງ  (Delivery Report) ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</title>
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
    <style>

      body {
      font-size:10px;
      }
    </style>
    <script type="text/javascript">
	
	   window.print();
	 	//window.close();
    </script>
  </head>
  
  <body>
 <!--  <div align="center" style="font-size:13px">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>LAO PEOPLE'S DEMOCRATIC REPUBLIC<br/>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ<br/>PEACE INDEPENDENCE DEMOCRACY UNITY PROSPERITY</div> -->
    <div class="container">

	 <table border="0" width="100%">
	 	<tr>
	 		<td rowspan="2" width="5%"> <img src="{{ URL::to('img/logo.png') }}" width="100"></td>
	 		<td width="50%">@if ($company->company_name)<b>{{ $company->company_name }} </b><br>@endif 
	 		@if ($company->address){{ $company->address }} <br>@endif
               @if ($company->telephone)ໂທລະສັບ: {{ @$company->telephone }} <br>@endif
                @if ($company->fax)ແຟກ: {{ @$company->fax }} <br>@endif
                @if ($company->mobile)Hotline: {{ @$company->mobile }} <br>@endif
                @if ($company->email)Email: {{ @$company->email }} @endif</td>
	 		<td align="right">
	 			<h4 style="font-size:20px">ລາຍງານ - ລາຍລະອຽດການສົ່ງ (Delivery Report)</h4><br>
	 			<h4>ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</h4>
	 			<h4>ພິມວັນທິ: {{ date('d-M-Y H:i:s') }} | ໂດຍ {{ $user }}</h4>
	 		</td>
	 	</tr>
	 </table>
      <!-- / end client details section -->
      <table class="tableStylingReport" cellspacing="0" cellpadding="0" width="100%">
        <thead>
          <tr style="background:#005186; color:#fff">
			<td>No.:</td>
			<td>Tran No.:</td>
			<td>D/O No.:</td>
			<td>Customer No.:</td>
			<td>Name:</td>
			<td>Send Location</td>
			<td>Date:</td>
			<td>Driver/Truck:</td>
			<td>Product ID:</td>
			<td>Quality:</td>
			<td>Remark:</td>
		</tr>
        </thead>
        <tbody>
        @foreach( $data as $row )
		
		<tr>
			<td>{{ $row['index'] }}</td>
			<td>{{ $row['transaction_number'] }}</td>
			<td>{{ $row['issue_slip_id'] }}</td>
			<td>{{ $row['customer_id'] }}</td>
			<td>{{ $row['customer_name'] }}</td>
			<td>{{ $row['send_location'] }}</td>
			<td>{{ $row['issue_date'] }}</td>
			<td>{{ $row['truck_number'] }}</td>
			<td>{{ $row['product_id'] }}</td>
			<td>{{ $row['quality'] }} m<sup>3</sup></td>
			<td>{{ $row['remark'] }}</td>
		</tr>
		
		@endforeach
		
		<tr style="background:#006600; color:#fff">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right">ລວມ:</td>
			<td>{{ $sum_quality }} m<sup>3</sup></td>
			<td>&nbsp;</td>
		</tr>
        </tbody>
      </table>


      <div class="row">
     	<div class="col-xs-8">
         
            <div class="panel-heading">
              <!-- <p><u>ຜູ້ອຳນວຍການ ບໍລິສັດ 1 ພຶດສະພາກຣຸບ ຈຳກັດຜູ້ດຽວ</u></p> -->
            </div>
            <div class="panel-body">
             
            </div>
     
        </div>
        </div>
    </div>
  </body>
</html>
