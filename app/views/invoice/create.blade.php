@include('layout.header')
{{ Form::open(array('url' => 'transaction/payment/submit')) }}
<input type="hidden" name="invoice_id" id="invoice_id" value="{{ Route::input('invoice_id') }}">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
ຊຳລະເງິນ
<hr/>
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td align="right">ລະຫັດ ໃບຮຽກເກັບເງິນ: <input type="hidden" name="prefix" value="{{ $customer->transaction_prefix }}{{Route::input('invoice_id')}}-"></td>
			<td>{{ $customer->transaction_prefix }}{{Route::input('invoice_id')}}-<input type="text" class="k-textbox" value="" id="" name="invoice_number" style="width:100px"></td>
		</tr>
		<tr>
			<td align="right">ລະຫັດ ລາຍການຂາຍ:</td>
			<td>{{ $customer->transaction_prefix }}<input type="text" class="k-textbox" value="" id="transaction_parent_id" name="transaction_parent_id" style="width:100px"></td>
		</tr>
		<tr>
			<td align="right">ວັນທີຊຳລະ: </td>
			<td><input type="text" value="{{ date('d-M-Y') }}" id="payment_date" name="payment_date"></td>
		</tr>
		
		<tr><td colspan="2"><hr/></td></tr>
		
		<tr>
			<td align="right">ຍອດເງິນ ທີ່ຕ້ອງຊຳລະ:</td>
			<td><input type="text" name="amount" placeholder="ຈຳນວນເງິນ..." id="amount" value="{{ TransactionPayment::getRemain(Route::input('invoice_id')) }}" readonly="readonly"></td>
		</tr>
		<tr>
			<td align="right">ຍອດເງິນ ຊຳລະຕົວຈິງ:</td>
			<td><input type="text" name="amountPaid" placeholder="ຈຳນວນເງິນ..." value="" max="{{ TransactionPayment::getRemain(Route::input('invoice_id')) }}" min='1' id="amountPaid"></td>
		</tr>
		<tr>
			<td colspan="2" align="right">
			<a href="javascript:history.back()" class="k-button">ຍົກເລີກ</a> 
			{{Form::submit('ບັນທຶກ', ['class' => 'k-button k-primary'])}}
			</td>
			
		</tr>

	</table>
</div>

</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){
		
		$("#payment_date").kendoDatePicker({
			format: "dd-MMM-yyyy"
		});

		$("#amount").kendoNumericTextBox();
		$("#amountPaid").kendoNumericTextBox();
		$("#invoice_number").kendoNumericTextBox();
		$("#payment_type").ddPayment();
	});
</script>
@include('layout.footer')