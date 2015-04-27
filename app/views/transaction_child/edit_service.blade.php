@include('layout.header')
{{ Form::open(array('url' => 'transaction_child/service/edit/submit')) }}
<input type="hidden" value="{{ Route::input('tran_child_id') }}" name="tran_child_id">
<input type="hidden" value="{{ Route::input('tran_parent_id') }}" name="tran_parent_id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
ແກ້ໄຂລາຍການ ບໍລິການ
<hr/>
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td colspan="2"><input type="text" class="k-textbox" name="service" id="service" value="{{ Service::find($TranChild->service_id)->service_name }}" style="width:100%" readonly="readonly"></td>
		</tr>
	 	<tr>
			<td align="right">ວັນທີສົ່ງ:</td>
			<td><input type="text" name="issue_date" placeholder="ວັນທີສົ່ງ..." id="issue_date" value="{{ date('d-M-Y',strtotime($TranChild->issue_date)) }}" ></td>
		</tr>
		<tr>
			<td align="right">ຈຳນວນ:</td>
			<td><input type="text" name="quality" placeholder="ຈຳນວນ..." id="quality" value="{{ $TranChild->quality }}" style="width:80%" min="0" step="0.50"> m<sup>3</sup></td>
		</tr>

		<tr>
			<td colspan="2"><textarea class="k-textbox" placeholder="ຫມາຍເຫດ..." style="width:100%" name="remark">{{ $TranChild->remark }}</textarea></td>
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
		var issue_date = $("#issue_date").kendoDatePicker({
			format : "dd-MMM-yyyy"
		}).data('kendoDatePicker');
		$("#quality").kendoNumericTextBox();

	});
</script>
@include('layout.footer')