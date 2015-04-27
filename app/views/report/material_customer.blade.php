@include('layout.header')

<h3>ລາຍງານ - ສະຫລຸບການຜະລິດແຍກຕາມລູກຄ້າ (Material Report by Cust.)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:100%">
<div class="floatLeft"><form method="get" action="report/">
ຈາກວັນທີ: <input type="text" name="date_start" id="date_start" value="{{ Route::input('date_start') }}"> ເຖີງ <input type="text" name="date_end" id="date_end" value="{{ Route::input('date_end') }}"> <button type="button" id="btnReport" class="k-button k-primary">ຕົກລົງ</button></form>
</div>
<div class="floatRight">
<a class="k-button" href="{{ URL::to('report/material/customer/date') }}/{{ Route::input('date_start') }}/{{ Route::input('date_end') }}?print=true" target="_blank">Print</a>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
	<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">
		<tr style="background:#005186; color:#fff">
			
			<td rowspan="2">No.:</td>
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
		
		@if($data)
		@foreach( $data as $row )
		
		<tr>
			<td>{{ $row['index'] }}</td>
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
			<td colspan="3" align="right">Total:</td>
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
		
		@else
		<tr>
			<td colspan="16" align="center">ຂໍອະໄພ, ບໍ່ພົບຂໍ້ມູນ</td>
		</tr>
		@endif
	</table>
</div>

</div>

<script type="text/javascript">
	$(document).ready(function(e){
		
		$("#date_start").kendoDatePicker({
			format : "dd-MMM-yyyy"
		});

		$("#date_end").kendoDatePicker({
			format : "dd-MMM-yyyy"
		});

		$("#btnReport").click(function(e){
			e.preventDefault();
			window.location.href = "{{ URL::to('/report/material/customer') }}/date/"+$("#date_start").val()+'/'+$("#date_end").val();
		});
	});
</script>
@include('layout.footer')