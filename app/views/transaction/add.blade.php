@include('layout.header')
{{ Form::open(array('url' => 'transaction/add/submit')) }}
<input type="hidden" name="transaction_status" value="{{ Route::input('status') }}">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
@if(Route::input('status')==0) ສ້າງ ໃບສະເຫນີລາຄາ @else ສ້າງ ໃບກັບເງິນ @endif
<hr/>
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td><input type="text" name="customer_id" id="customer_id" value="" style="width:100%"></td>
		</tr>
		<tr>
			<td><input type="text" name="transaction_date" id="transaction_date" placeholder="ວັນທີ..." value="{{ date('d-M-Y') }}"></td>
		</tr>
		<tr>
			<td><input type="text" name="company_name" placeholder="ຊື່ ລູກຄ້າ ຫລື ບໍລິສັດ..." id="company_name" class="k-textbox" value="" style="width:100%"></td>
		</tr>
		<tr>
			<td><input type="text" name="contact_name" placeholder="ຊື່ ຜູ້ຕິດຕໍ່..." id="contact_name" class="k-textbox" value="" style="width:100%"></td>
		</tr>
		<tr>
			<td><input type="text" name="contact_telephone" placeholder="ເບິໂທລະສັບ..." id="contact_telephone" class="k-textbox" value="" style="width:100%"></td>
		</tr>
		
		<tr>
			<td><input type="text" name="send_location" placeholder="ສະຖານທີ່ສົ່ງ..." id="send_location" class="k-textbox" value="" style="width:100%"></td>
		</tr>
		@if(Route::input('status')==0)
		<tr>
			<td align="right">ໃບສະເຫນີລາຄາ ໝົດກຳໜົດ ວັນທີ: <input type="text" id="quotation_expired_at" name="quotation_expired_at" value="{{ date('d-M-Y',strtotime('+15 days')) }}"></td>
		</tr>
		@endif
		<tr>
		
			<td align="right">ຄ່າປັບໄຫມຕໍ່ m<sup>3</sup> (THB): <input type="number" min="0" id="penalty_per_m3" name="penalty_fee_m3" value="0"></td>
		</tr>
		
		<tr>
			<td align="right">ອ/ຕ ດອກເບ້ຍ ຄ້າງຊຳລະ (%):  <input type="text" name="overpaid_charge_percentage" id="overpaid_charge_percentage" value="0" min="0" step="0.5"></td>
		</tr>
		<tr>
			<td align="right">ໄລຍະເວລາຊຳລະຫນີ້ (ມື້): <input type="text" id="dept_duration" name="dept_duration" value="0" min="0"></td>
		</tr>
		<tr>
			<td colspan="2" align="right">
			<a href="#" onClick="javascript:history.back()" class="k-button">ຍົກເລີກ</a> 
			{{Form::submit('ບັນທຶກ', ['class' => 'k-button k-primary'])}}
			</td>
			
		</tr>
	</table>
</div>

</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){

		$("#penalty_per_m3").kendoNumericTextBox().data('kendoNumericTextBox');
		$("#dept_duration").kendoNumericTextBox();
		$("#overpaid_charge_percentage").kendoNumericTextBox();

		$("#transaction_date").kendoDatePicker({
			format: "dd-MMM-yyyy"
		});

		$("#quotation_expired_at").kendoDatePicker({
			format: "dd-MMM-yyyy"
		});
		
		// Dropdown Customer list
		$("#customer_id").kendoDropDownList({
			dataValueField: "id",
	        dataTextField: "company_name",
	        autoBind: true,
	        change: function(e) {
		        
	            var id = this.value() > 0 ? this.value() : 0;

	            if( id > 0 ) {

            		$.ajax({
    					url : 'customer/json/get/data/'+id,
    					type : 'GET',
    					success : function(returnData) {

    		            	$("#company_name").val(returnData['company_name']);
    		            	$("#contact_name").val(returnData['contact_name']);
    		            	$("#contact_telephone").val(returnData['telephone']);
    		            	$("#dept_duration").data('kendoNumericTextBox').value(returnData['dept_duration'] > 0 ? returnData['dept_duration'] : 0);
    		            	$("#penalty_per_m3").data('kendoNumericTextBox').value(returnData['penalty_fee_m3'] > 0 ? returnData['penalty_fee_m3'] : 0);
    		           		$("#overpaid_charge_percentage").data('kendoNumericTextBox').value(returnData['overpaid_charge_percentage'] > 0 ? returnData['overpaid_charge_percentage'] : 0);
    					}
    				});
	       
	            } else {

	            	$("#company_name").val("");
	            	$("#contact_name").val("");
	            	$("#contact_telephone").val("");
	            	$("#dept_duration").data('kendoNumericTextBox').value(0);
	           		$("#overpaid_charge_percentage").data('kendoNumericTextBox').value(0);
	            }
				
	        },
	        optionLabel: {
	        	company_name: '- ລາຍການລູກຄ້າ -',
	            id: ""
	        },
	        dataSource: {
	            transport: {
	                read: {
	                	url: "{{ URL::to('customer/json/list') }}",
	                    dataType: "json",
	                }
	            }
	        }
		});
	});
</script>
@include('layout.footer')