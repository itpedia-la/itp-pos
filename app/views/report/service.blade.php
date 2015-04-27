@include('layout.header')

<h3>ລາຍງານ - ການບໍລິການ (Service Report)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:100%">
<div class="floatLeft"><form method="get" action="report/">
ຈາກວັນທີ: <input type="text" name="date_start" id="date_start" value="{{ Route::input('date_start') }}"> ເຖີງ <input type="text" name="date_end" id="date_end" value="{{ Route::input('date_end') }}"> <button type="button" id="btnReport" class="k-button k-primary">ຕົກລົງ</button></form>
</div>
<div class="floatRight">
<a class="k-button" href="{{ URL::to('report/service/date') }}/{{ Route::input('date_start') }}/{{ Route::input('date_end') }}?print=true" target="_blank">Print</a>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
	<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">
		<tr style="background:#005186; color:#fff">
			<td>No.:</td>

			<td>Customer Nname</td>
			<td>Service name</td>
			<td>Quality</td>
            <td>Unit Price</td>
            <td>Total</td>
		</tr>
		
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
			window.location.href = "{{ URL::to('/report/service') }}/date/"+$("#date_start").val()+'/'+$("#date_end").val();
		});
	});
</script>
@include('layout.footer')