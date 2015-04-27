<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>ລາຍງານ - ສະຫລຸບການຜະລິດແຍກຕາມລູກຄ້າ (Material Report by Cust.) ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</title>
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
	 			<h4 style="font-size:20px">ລາຍງານ - ສະຫລຸບການຜະລິດແຍກຕາມລູກຄ້າ (Material Report by Cust.)</h4><br>
	 			<h4>ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</h4>
	 			<h4>ພິມວັນທິ: {{ date('d-M-Y H:i:s') }} | ໂດຍ {{ $user }}</h4>
	 		</td>
	 	</tr>
	 </table>
      <!-- / end client details section -->
      <table class="tableStylingReport" cellspacing="0" cellpadding="0" width="100%">
        <thead>
          <tr style="background:#005186; color:#fff">
			
			<td rowspan="2">Customer</td>
			<td rowspan="2">Product name / Code</td>
			<td rowspan="2" align="center">Qty<br/>(m<sup>3</sup>)</td>
			<td rowspan="2" align="center">Rock<br/>(Tons)</td>
			<td rowspan="2" align="center">Sand<br/>(Tone)</td>
			<td rowspan="2" align="center">Water<br/>(Litre)</td>
			<td colspan="6" align="center">Cement (Tons)</td>
			<td colspan="3" align="center">Admixture (Litre)</td>
		</tr>
		<tr style="background:#005186; color:#fff">
			
			<td align="center">Cm 1</td>
			<td align="center">Cm 2</td>
			<td align="center">Cm 3</td>
			<td align="center">Cm 4</td>
			<td align="center">Cm 5</td>
			<td align="center">Cm 6</td>
			<td align="center">Adx 1 (ໄທຈີ)</td>
			<td align="center">Adx 2</td>
			<td align="center">Adx 3</td>
		</tr>
        </thead>
        <tbody>
        @foreach( $data as $row )
		
		<tr>
			<td>{{ $row['customer'] }}</td>
			<td>{{ $row['product'] }}</td>
			<td align="right">{{ $row['quality'] }}</td>
			<td align="right">{{ $row['rock'] }}</td>
			<td align="right">{{ $row['sand'] }}</td>
			<td align="right">{{ $row['water'] }}</td>
			<td align="right">{{ $row['cement_1'] }}</td>
			<td align="right">{{ $row['cement_2'] }}</td>
			<td align="right">{{ $row['cement_3'] }}</td>
			<td align="right">{{ $row['cement_4'] }}</td>
			<td align="right">{{ $row['cement_5'] }}</td>
			<td align="right">{{ $row['cement_6'] }}</td>
			<td align="right">{{ $row['adx_1'] }}</td>
			<td align="right">{{ $row['adx_2'] }}</td>
			<td align="right">{{ $row['adx_3'] }}</td>
		</tr>
		
		@endforeach
		<tr style="background:#555; color:#fff">
		<td colspan="2" align="right">Total:</td>
			<td align="right"><b>{{ $sum['total_qty'] }}</b></td>
			<td align="right"><b>{{ $sum['total_rock'] }}</b></td>
			<td align="right"><b>{{ $sum['total_sand'] }}</b></td>
			<td align="right"><b>{{ $sum['total_water'] }}</b></td>
			<td align="right"><b>{{ $sum['total_cm_1'] }}</b></td>
			<td align="right"><b>{{ $sum['total_cm_2'] }}</b></td>
			<td align="right"><b>{{ $sum['total_cm_3'] }}</b></td>
			<td align="right"><b>{{ $sum['total_cm_4'] }}</b></td>
			<td align="right"><b>{{ $sum['total_cm_5'] }}</b></td>
			<td align="right"><b>{{ $sum['total_cm_6'] }}</b></td>
			<td align="right"><b>{{ $sum['total_adx_1'] }}</b></td>
			<td align="right"><b>{{ $sum['total_adx_2'] }}</b></td>
			<td align="right"><b>{{ $sum['total_adx_3'] }}</b></td>
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
