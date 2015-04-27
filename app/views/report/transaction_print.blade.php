<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>ລາຍງານ - ລາຍລະອຽດ ການຂາຍ ແລະ ການຊຳລະເງິນ (Transaction and Payment Report) ຈາກວັນທີ: {{ Tool::toDate(Route::input('date_start')) }} ເຖີງ {{ Tool::toDate(Route::input('date_end')) }}</title>
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
    <style>
    body { font-size:10px }
    .header_1 { background:#278BCB; color:#fff; font-weight:bold }
	 .header_2 { background:#A8DFF4; color:#000 }
	 .header_3 { background:#FFF6DF; font-weight:bold; color:#000 }
	
	@media print {
	body { font-size:10px }
	 .header_1 { background:#278BCB; color:#fff; font-weight:bold }
	 .header_2 { background:#A8DFF4; color:#000 }
	 .header_3 { background:#FFF6DF; font-weight:bold; color:#000 }
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
	 			<h4 style="font-size:20px">ລາຍງານ - ລາຍລະອຽດ ການຂາຍ ແລະ ການຊຳລະເງິນ (Transaction and Payment Report)</h4><br>
	 			<h4>ຈາກວັນທີ: {{ Tool::toDate($date['start_date']) }} ເຖີງ {{ Tool::toDate($date['end_date']) }}</h4>
	 			<h4>ພິມວັນທິ: {{ date('d-M-Y H:i:s') }} | ໂດຍ {{ $user }}</h4>
	 		</td>
	 	</tr>
	 </table>
      <!-- / end client details section -->
      <table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">

		<tr style="background:#278BCB; color:#fff">
			<td colspan="2" align="center">ລາຍການລູກຄ້າ/ ລະຫັດລາຍການຂາຍ</td>
            <td align="center">ລະຫັດໃບຮຽກເກັບເງິນ / ສະຖານທີ່ສົ່ງ</td>
            <td align="center">ລວມ m<sup>3</sup></td>
            <td align="center">ລວມ ເງິນທັງໝົດ</td>
            <td align="center">ລວມ ຍອດເງິນຊຳລະແລ້ວ</td>
            <td align="center">ລວມ ຍອດເງິນຄ້າງຊຳລະ</td>
            <td align="center">ວັນທີ</td>
		</tr>
		@if(@$data)
		
		@foreach( array_slice($data,0,-1) as $row )
		@if(@$row['customer']!="")
		<tr style="background:#A8DFF4; color:#000">
			<td colspan="2">{{ $row['index'] }}.) {{ @$row['customer'] }}</td>
            <td>{{ $row['invoice_number'] }}</td>
            <td align="right">{{ @$row['sum_m3'] }}</td>
            <td align="right">{{ @$row['sum_grand_total_all'] }}</td>
            <td align="right">{{ @$row['invoice_paid'] }}</td>
            <td align="right">{{ @$row['invoice_remain'] }}</td>
            <td align="right">{{ @$row['invoice_status_html'] }}</td>
		</tr>
		@else
		<tr style="background:#FFF6DF; font-weight:bold; color:#000">
			<td align="right">{{ @$row['index'] }}.)</td>
            <td>{{ @$row['id'] }}</td>
            <td>{{ @$row['send_location'] }}</td>
            <td align="right">{{ @$row['sum_m3_child'] }}</td>
            <td align="right">{{ @$row['grand_total_html'] }}</td>
            <td align="right">{{ @$row['invoice_remain'] }}</td>
            <td align="right">{{ @$row['invoice_status_html'] }}</td>
            <td>{{ @$row['transaction_date'] }}</td>
		</tr>
		@if( @$row['transaction_childs'] )
		@foreach( $row['transaction_childs'] as $child)
			<tr >
			<td>&nbsp;</td>
            <td>{{ $child['issue_slip_id'] }}</td>
            <td>{{ $child['title'] }}</td>
            <td align="right">{{ @$child['quality'] }}</td>
            <td align="right">{{ @$child['total'] }} THB</td>
            <td align="right">{{ @$row['invoice_remain'] }}</td>
            <td align="right">&nbsp;</td>
            <td>{{ @$child['issue_date'] }}</td>
		</tr>
		@endforeach
		@endif
		@endif
		@endforeach
		<tr style="background:#278BCB; color:#fff">
			<td colspan="2" align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">ລວມ m<sup>3</sup></td>
            <td align="center">ລວມ ເງິນທັງໝົດ</td>
            <td align="center">ລວມ ຍອດເງິນຊຳລະແລ້ວ</td>
            <td align="center">ລວມ ຍອດເງິນຄ້າງຊຳລະ</td>
            <td align="center">&nbsp;</td>
		</tr>
		<tr style="background:#278BCB; color:#fff; font-weight:bold">
			<td colspan="2" align="center">&nbsp;</td>
            <td align="right">ຍອດລວມປະຈຳເດືອນ:</td>
            <td align="center">{{ end($data)['grand_sum_m3'] }} m<sup>3</sup></td>
            <td align="center">{{ end($data)['grand_sum_total'] }} THB</td>
            <td align="center">{{ end($data)['grand_sum_paid'] }} THB</td>
            <td align="center">{{ end($data)['grand_sum_remain'] }} THB</td>
            <td align="center">&nbsp;</td>
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
