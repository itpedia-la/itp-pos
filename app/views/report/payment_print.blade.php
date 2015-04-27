<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>ລາຍງານ - ໃບຮຽກເກັບເງິນ  (Payment Report) ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</title>
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
	 			<h4 style="font-size:20px">ລາຍງານ - ໃບຮຽກເກັບເງິນ (Payment Report)</h4><br>
	 			<h4>ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</h4>
	 			<h4>ພິມວັນທິ: {{ date('d-M-Y H:i:s') }} | ໂດຍ {{ $user }}</h4>
	 		</td>
	 	</tr>
	 </table>
      <!-- / end client details section -->
     		<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">
		
		
		@if($data)
			@foreach( $data as $row )
			
			<tr style="background:#005186; color:#fff">
				<td>{{ $row['index'] }}.)</td>
				<td>{{ $row['transaction_number'] }}</td>
				<td colspan="10">{{ $row['customer'] }}</td>
			</tr>
			<tr style="background:#D6D6D6; color:#000">
				<td>No.:</td>
				<td>ລະຫັດ ໃບຮຽກເກັບເງິນ</td>
				<td>ປະເພດການຊຳລະ</td>
				
				<td>ຍອດລວມ (THB)</td>
				
				<td>ວັນທີ ອອກໃບຮຽກເກັບເງິນ</td>
				<td>ວັນທີ ກຳໜົດຊຳລະ</td>
				<td>ອອກໂດຍ</td>
				<td>ສະຖານະ</td>
				<td>ຮັບເງິນໂດຍ</td>
				<td>ວັນທີ ຊຳລະເງິນ</td>
			</tr>
			@foreach( $row['payment'] as $paymentRow )
				<tr >
					<td>{{ $paymentRow['index'] }}.)</td>
					<td>{{ $paymentRow['transaction_number_sub'] }}</td>
					<td>{{ $paymentRow['payment_type'] }}</td>
					<td>{{ $paymentRow['amount'] }}</td>
					
					<td>{{ $paymentRow['payment_date'] }}</td>
					<td>{{ $paymentRow['payment_due_date'] }}</td>
					<td>{{ $paymentRow['user'] }}</td>
					<td>{{ $paymentRow['status_html'] }}</td>
					<td>{{ @$paymentRow['receiver'] }}</td>
					<td>{{ @$paymentRow['paid_at'] }}</td>
				</tr>
			@endforeach
			
			@endforeach
			
			
			
		@else
		<tr>
			<td colspan="11" align="center">ຂໍອະໄພ, ບໍ່ພົບຂໍ້ມູນ</td>
		</tr>
		@endif
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
