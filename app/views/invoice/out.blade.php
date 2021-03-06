@include('layout.header')
{{ Form::open(array('url' => 'invoice/out/submit')) }}
<input type="hidden" value="{{ Route::input('invoice_id') }}" name="invoice_id" id="invoice_id">
<h3>ລາຍການ ໃບຮຽກເກັບເງິນ (Invoice)</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">

<b>ອອກໃບ ຮຽກເກັບເງິນ</b>

<hr/>
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="center">ທ່ານຕ້ອງການອອກ ໃບຮຽກເກັບເງິນ ເລກທີ "{{ TransactionInvoice::find(Route::input('invoice_id'))->invoice_number}} ຫລືບໍ່?"</td>
		</tr>
		<tr>
			<td align="right">ວັນທີ ອອກໃບຮຽກເກັບເງິນ: <input type="text" value="{{ date('d-M-Y') }}" id="invoice_issue_date" name="invoice_issue_date"></td>
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
		$("#invoice_issue_date").kendoDatePicker({
			format: "dd-MMM-yyyy"
		});
	});
</script>
@include('layout.footer')