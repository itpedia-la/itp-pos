@include('layout.header')
{{ Form::open(array('url' => 'transaction_child/product/edit/submit')) }}
<input type="hidden" value="{{ Route::input('tran_child_id') }}" name="tran_child_id">
<input type="hidden" value="{{ Route::input('tran_parent_id') }}" name="tran_parent_id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
ແກ້ໄຂ ລາຍການ ສິນຄ້າ 
<hr/>
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		@if($TranParent->transaction_status!=0)
		<tr>
			<td><input type="text" name="issue_slip_id" placeholder="ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ..." id="issue_slip_id" class="k-textbox" value="{{ $TranChild->issue_slip_id }}" style="width:100%"></td>
			<td><input type="text" name="issue_date" placeholder="ວັນທີເບີກຈ່າຍສິນຄ້າ..." id="issue_date" value="{{ Tool::toDateTime($TranChild->issue_date) }}" style="width:100%"></td>
		</tr>
	@endif

		<tr>
			<td align="right">ຈຳນວນ:</td>
			<td><input type="text" name="quality" placeholder="ຈຳນວນ..." id="quality" style="width:80%" min="0" value="{{ $TranChild->quality }}" step="0.50"> m<sup>3</sup></td>
		</tr>
		@if($TranParent->transaction_status!=0)
		<tr>
			<td align="right">ຫມາຍເລກລົດ:</td>
			<td><input type="text" name="truck_number" placeholder="ທະບຽນລົດ..." class="k-textbox" id="truck_number" value="{{ $TranChild->truck_number }}" style="width:100%" min="0"></td>
		</tr>
		@endif
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

		var issue_date = $("#issue_date").kendoDateTimePicker({
			format : "dd-MMM-yyyy hh:mm"
		}).data('kendoDateTimePicker');



		$("#quality").kendoNumericTextBox();
		
		// Dropdown Project list
		$("#product_id").kendoDropDownList({
			dataValueField: "id",
	        dataTextField: "title_html",
	        autoBind: true,
	        change: function(e) {

	        },
	        optionLabel: {
	        	title_html: '- ລາຍການ ສິນຄ້າ -',
	            id: ""
	        },
	        dataSource: {
	            transport: {
	                read: {
	                	url: "{{ URL::to('product/json/list') }}",
	                    dataType: "json",
	                }
	            }
	        }
		});
	});
</script>
@include('layout.footer')