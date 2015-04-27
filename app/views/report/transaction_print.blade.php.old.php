<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>ລາຍງານ - ລາຍລະອຽດການຂາຍ (Transaction Report) ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</title>
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
	 			<h4 style="font-size:20px">ລາຍງານ - ລາຍລະອຽດການຂາຍ (Transaction Report)</h4><br>
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
            <td colspan="5">{{ $row['customer'] }}</td>
		</tr>
		<tr style="background:#D6D6D6; color:#000">
			<td>ອັນດັບ.:</td>
			<td>ລະຫັດໃບເບີກຈ່າຍສິນຄ້າ</td>
			<td>ສິນຄ້າ</td>
			<td align="center">ຈຳນວນ</td>
			<td align="center">ລາຄາ</td>
			<td align="center">ຍອດລວມ</td>
			<td>ວັນທີ:</td>
			
		</tr>
		
		@foreach( $row['childs'] as $child_row )
		
		@if($child_row['footer'] == false)
		<tr>
			<td>{{ @$child_row['index'] }}</td>
			<td>{{ @$child_row['issue_slip_id'] }}</td>
			<td>{{ @$child_row['title'] }}</td>
			<td align="right">{{ @$child_row['quality'] }}</td>
			<td align="right">{{ @$child_row['price'] }} THB</td>
			<td align="right">{{ @$child_row['total'] }} THB</td>
			<td>{{ @$child_row['issue_date'] }}</td>
			
		</tr>
		@else
		<tr {{ @$child_row['style'] }}>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><u>{{ @$child_row['quality'] }} m<sup>3</sup></u></td>
			<td align="right"><u>ລວມທັງໝົດ:</u></td>
			<td align="right"><u>{{ @$child_row['grand_total'] }} THB</u></td>
			<td>{{ @$child_row['issue_date'] }}</td>
		</tr>
		<tr {{ @$child_row['style'] }}>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><u>ຊຳລະແລ້ວ:</u></td>
			<td align="right"><u>({{ @$child_row['paid'] }} THB)</u></td>
			<td>&nbsp;</td>
		</tr>
		<tr {{ @$child_row['style'] }}>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><u>ຍອດຄ້າງຊຳລະ:</u></td>
			<td align="right"><u>{{ @$child_row['remaining'] }} THB</u></td>
			<td>&nbsp;</td>
		</tr>
		@endif
		
		@endforeach

		@endforeach
		
		<tr style="background:#006600; color:#fff">
			<td colspan="2" align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><b>ຍອດລວມທັງໝົດ: </b></td>
			<td align="right"><b>{{ $sum['sum_grand_total'] }} THB</b></td>
			<td align="right">&nbsp;</td>
		</tr>
<tr style="background:#006600; color:#fff">
			<td colspan="2" align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><b>ຍອດຊຳລະທັງໝົດ:</b></td>
			<td align="right"><b>({{ $sum['sum_paid'] }} THB)</b></td>
			<td align="right">&nbsp;</td>
		</tr>
		<tr style="background:#006600; color:#fff">
			<td colspan="2" align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><b>ຍອດຄ້າງຊຳລະທັງໝົດ:</b></td>
			<td align="right"><b>{{ $sum['sum_ramaining'] }} THB</b></td>
			<td align="right">&nbsp;</td>
		</tr>
		
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
