@include('layout.header')
{{ Form::open(array('url' => 'transaction/payment/remove/submit')) }}
<input type="hidden" value="{{ Route::input('payment_id') }}" name="payment_id">
<h3>ລາຍການ ສິນຄ້າ</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">

<b>ລົບລ້າງ ລາຍການ ຊຳລະເງິນ ເລກທີ "{{ TransactionPayment::find(Route::input('payment_id'))->invoice_number}}"</b>

<hr/>

	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td>ທ່ານຕ້ອງ ການລົບລ້າງ ລາຍການຊຳລະເງິນ ນີ້ຫລືບໍ່?</td>
		</tr>

		<tr>
	
			<td align="right">
				<a href="#" class="k-button" onClick="javascript:history.back()" >ຍົກເລີກ</a> 
			{{Form::submit('ຕົກລົງ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){
		// Button Back
		$("#btnBack").click(function(e){
			window.location.href="{{ URL::to('product') }}";
		});
	});
</script>
@include('layout.footer')