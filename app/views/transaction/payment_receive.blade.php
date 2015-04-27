@include('layout.header')
{{ Form::open(array('url' => 'transaction/payment/receive/submit')) }}
<input type="hidden" value="{{ Route::input('tran_payment_id') }}" name="tran_payment_id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:50%">

<b>ຮັບເງິນ "ໃບຮຽກເກັບເງິນ"</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td>ຮັບເງິນຈາກ "ໃບຮຽກເກັບເງິນ" ເລກທີ: {{ $tran_payment->transaction_number_sub }} ຈຳນວນ {{ number_format($tran_payment->amount,2) }} THB</td>
		</tr>

		<tr>
			
			<td align="right">ວັນທີຊຳລະເງິນ: <input type="text" name="paid_at" placeholder="ກຳຫນົດຊຳລະວັນທີ່..." id="paid_at" value="{{ date('d-M-Y') }}"></td>
		</tr>
		
		<tr>
	
			<td align="right">
				<button class="k-button" href="javascript:history.back()">ຍົກເລີກ</button> 
			{{Form::submit('ຕົກລົງ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){

		var paid_at = $("#paid_at").kendoDatePicker({
			format : "dd MMM yyyy"
		}).data('kendoDatePicker');

	});
</script>
@include('layout.footer')