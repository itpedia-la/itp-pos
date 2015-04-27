@include('layout.header')
{{ Form::open(array('url' => 'transaction/create/invoice/submit')) }}
<input type="hidden" name="customer_id" value="{{ Route::input('customer_id') }}">
<input type="hidden" name="transaction_parent_str" value="{{ Route::input('transaction_parent_str') }}">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
ສ້າງ ໃບຮຽກເກັບເງິນ
<hr/>
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td><input type="text" value="{{ Customer::find(Route::input('customer_id'))->company_name }}" style="width:100%" readonly="readonly" class="k-textbox"></td>
		</tr>
		<tr>
			<td align="right">ຈາກວັນທີ: <input type="text" readonly="readonly" name="date_start" class="k-textbox" value="{{ $date['date_start'] }}" > ເຖິງ <input type="text"  class="k-textbox" value="{{ $date['date_end'] }}" name="date_end" readonly="readonly" ></td>
		</tr>
		<tr><td><hr/></td></tr>
		<tr>
			<td align="right">ວັນທີ່ ອອກໃບຮຽກເກັບເງິນ: <input type="text" value="{{ date('d-M-Y') }}" name="payment_date" id="payment_date" ></td>
		</tr>
		<tr>
			<td align="right">ກຳໜົດຊຳລະວັນທີ: <input type="text" value="{{ date('d-M-Y', strtotime('+30 days'))}}" id="payment_due_date" name="payment_due_date" ></td>
		</tr>

		<tr>
			<td align="right">THB: <input type="text" name="amount" placeholder="ຈຳນວນເງິນ..." id="amount" value="{{ $sum }}" readonly="readonly" style="width:200px"></td>
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

		$("#payment_due_date").kendoDatePicker({
			format: "dd-MMM-yyyy"
		});

		$("#amount").kendoNumericTextBox({
			spin : function() { totalCalc();  } ,
			change : function() { totalCalc();  } 
		});
		$("#amount_usd").kendoNumericTextBox();
		$("#amount_lak").kendoNumericTextBox();

	
		$("#payment_type").ddPayment();
	});
</script>
@include('layout.footer')