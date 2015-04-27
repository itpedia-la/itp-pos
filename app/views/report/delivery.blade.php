@include('layout.header')

<h3>ລາຍງານ - ລາຍລະອຽດການສົ່ງ (Delivery Report)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:100%">
<div class="floatLeft"><form method="get" action="report/">
ຈາກວັນທີ: <input type="text" name="date_start" id="date_start" value="{{ Route::input('date_start') }}"> ເຖີງ <input type="text" name="date_end" id="date_end" value="{{ Route::input('date_end') }}"> <button type="button" id="btnReport" class="k-button k-primary">ຕົກລົງ</button></form>
</div>
<div class="floatRight">
<a class="k-button" href="{{ URL::to('report/delivery/date') }}/{{ Route::input('date_start') }}/{{ Route::input('date_end') }}?print=true" target="_blank">Print</a>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
	<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">
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
		
		@if($data)
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
			window.location.href = "{{ URL::to('/report/delivery') }}/date/"+$("#date_start").val()+'/'+$("#date_end").val();
		});
	});
</script>
@include('layout.footer')