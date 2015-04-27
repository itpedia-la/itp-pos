@include('layout.header')
{{ Form::open(array('url' => 'customer/save')) }}

<h3>ລາຍການ ລູກຄ້າ</h3>
<hr class="hrHeader"/>

<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ເພິ່ມຂໍ່ມູນລູກຄ້າໃຫມ່</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
<!-- <div class="message green">Successfull</div> -->
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
	
		<tr>
			<td>ບໍລິສັດ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="company_name" value=""></td>
		</tr>
		<!-- <tr>
			<td>&nbsp;</td>
			<td><input type="text" style="width:100%" name="customer_type" value="" id="customer_type"></td>
		</tr> -->
		<tr>
			<td>ລະຫັດຫົວບິນ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="transaction_prefix" value=""></td>
		</tr>
		<tr>
			<td>ຊື່ຜູ້ຕິດຕໍ່:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="contact_name"></td>
		</tr>
		<tr>
			<td>ທີ່ຢູ່:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="address"></td>
		</tr>
<tr>
			<td>ເບີໂທ:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="telephone" value=""></td>
		</tr>
		<tr>
			<td>ແຟັກ:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="fax" value=""></td>
		</tr>
		
		<tr>
			<td>ເບີມືຖື:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="mobile" value=""></td>
		</tr>
		
		<tr>
			<td>email:</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="email" value=""></td>
		</tr>
		
		<!--<tr>
			<td>ສະຖານທີ່ສົ່ງ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="send_location" value=""></td>
		</tr>  -->
		<!--<tr>
			<td>ຄ່າປັບໄຫມຕໍ່ m<sup>3</sup> (THB): *</td>
			<td><input type="number" min="0" id="penalty_per_m3" style="width:100%" name="penalty_fee_m3" value="0"></td>
		</tr>  -->
		<tr>
			<td>ໄລຍະເວລາຊຳລະ: *</td>
			<td><input type="number" min="0" id="dept_duration" style="width:100%" name="dept_duration" value="0"></td>
		</tr>
		<tr>
			<td>ອ/ຕ ດອກເບ້ຍ ຄ້າງຊຳລະ: *</td>
			<td><input type="number" min="0" id="overpaid_charge_percentage" style="width:100%" name="overpaid_charge_percentage" value="0" step="0.5"></td>
		</tr>
		
		

		<tr>
			<td>&nbsp;</td>
			
			<td align="right">
	
			<a href="#" onClick="javascript:history.back();" class="k-button">ກັບຄືນ</a>&nbsp;{{Form::submit('ເພີ່ມ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">

	$(document).ready(function(e){
		
	    var overpaid_charge_percentage = $("#overpaid_charge_percentage").kendoNumericTextBox().data('kendoNumericTextBox');
	   		overpaid_charge_percentage.enable(true);
	    
	   

	    var dept_duration = $("#dept_duration").kendoNumericTextBox().data('kendoNumericTextBox');
	    	//dept_duration.enable(false);
	    
		/*$("#customer_type").ddCustomerType({
			change : function(value) {

				overpaid_charge_percentage.value(0);
				penalty_per_m3.value(0);
				
				if( value == 15 ) {
					
					penalty_per_m3.enable(true);
					overpaid_charge_percentage.enable(false);
					
				} else {

					penalty_per_m3.enable(false);
					overpaid_charge_percentage.enable(true);
				}

				dept_duration.value(value);
			}
		});*/
	});
</script>
@include('layout.footer')