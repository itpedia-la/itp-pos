@include('layout.header')

<h3>ລາຍງານ - ໃບຮຽກເກັບເງິນ (Payment Report)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:100%">
<div class="floatLeft"><form method="get" action="report/">
ຈາກວັນທີ: <input type="text" name="date_start" id="date_start" value="{{ Route::input('date_start') }}"> ເຖີງ <input type="text" name="date_end" id="date_end" value="{{ Route::input('date_end') }}"> <button type="button" id="btnReport" class="k-button k-primary">ຕົກລົງ</button></form>
</div>
<div class="floatRight">
<a class="k-button" href="{{ URL::to('report/payment/date') }}/{{ Route::input('date_start') }}/{{ Route::input('date_end') }}?print=true" target="_blank">Print</a>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
	<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">
		
		
		@if($data)
			@foreach( $data as $row )
			
			<tr style="background:#005186; color:#fff">
				<td>{{ @$row['index'] }}.)</td>
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
			window.location.href = "{{ URL::to('/report/payment') }}/date/"+$("#date_start").val()+'/'+$("#date_end").val();
		});
	});
</script>
@include('layout.footer')