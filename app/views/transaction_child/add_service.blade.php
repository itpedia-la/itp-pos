@include('layout.header')
{{ Form::open(array('url' => 'transaction_child/service/add/submit')) }}
<input type="hidden" value="{{ Route::input('transaction_parent_id') }}" name="transaction_parent_id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
ເພີ່ມລາຍການ
<hr/>
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td colspan="2"><input type="text" name="service_id" id="service_id" value="" style="width:100%"></td>
		</tr>
		 <tr>
			<td align="right">ວັນທີສົ່ງ:</td>
			<td><input type="text" name="issue_date" placeholder="ວັນທີສົ່ງ..." id="issue_date" value="{{ date('d-M-Y') }}" ></td>
		</tr>

		<tr>
			<td align="right">ຈຳນວນ:</td>
			<td><input type="text" name="quality" placeholder="ຈຳນວນ..." id="quality" value="0" min="0" step="0.50"></td>
		</tr>
		<!--<tr>
			<td align="right">ຫມາຍເລກລົດ:</td>
			<td><input type="text" name="truck_number" placeholder="ທະບຽນລົດ..." class="k-textbox" id="truck_number" style="width:100%" min="0"></td>
		</tr>-->
		<tr>
			<td colspan="2"><textarea class="k-textbox" placeholder="ຫມາຍເຫດ..." style="width:100%" name="remark"></textarea></td>
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

		// Dropdown Project list
		$("#service_id").kendoDropDownList({
			dataValueField: "id",
	        dataTextField: "service_name_html",
	        autoBind: true,
	        change: function(e) {

	        },
	        optionLabel: {
	        	service_name_html: '- ລາຍການ ການບໍລິການ -',
	            id: ""
	        },
	        dataSource: {
	            transport: {
	                read: {
	                	url: "{{ URL::to('service/json/list') }}",
	                    dataType: "json",
	                }
	            }
	        }
		});
	});
</script>
@include('layout.footer')