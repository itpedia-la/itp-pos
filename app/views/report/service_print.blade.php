<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>ລາຍງານ - ການບໍລິການ (Service Report) ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</title>
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
	 			<h4 style="font-size:20px">ລາຍງານ - ການບໍລິການ (Service Report)</h4><br>
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

			<td>Customer Nname</td>
			<td>Service name</td>
			<td>Quality</td>
            <td>Unit Price</td>
            <td>Total</td>
		</tr>
        </thead>
        <tbody>
        @if($data)
		@foreach( $data as $row )
		
		<tr>
			<td>{{ $row['index'] }}</td>

			<td>{{ $row['customer'] }}</td>
			<td>{{ $row['service_name'] }}</td>
            <td align="right">{{ $row['quality'] }}</td>
            <td align="right">{{ $row['price'] }} THB</td>
            <td align="right">{{ $row['total'] }} THB</td>
		</tr>
		
		@endforeach
		
		<tr style="background:#555; color:#fff">
		      <td colspan="5" align="right" >Total:</td>

			<td align="right"><b>{{ $sum['sum_total'] }} THB</b></td>
			</tr>
		
		@else
		<tr>
			<td colspan="11" align="center">ຂໍອະໄພ, ບໍ່ພົບຂໍ້ມູນ</td>
		</tr>
		@endif
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
