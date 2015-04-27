@include('layout.header') {{ Form::open(array('url' =>
'product/save')) }}

<h3>ລາຍການ ສິນຄ້າ</h3>
<hr class="hrHeader" />
<div align="center">

	<div class="k-block extended auto" style="width: 80%">
		<b>ເພິ່ມຂໍ້ມູນສິນຄ້າ</b>

		<hr />
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
		<!-- <div class="message green">Successfull</div> -->
		<table class="tableStyling" cellpadding="0" cellspacing="0"
			width="100%">

			<tr>
				<td>ຊື່ສິນຄ້າ: *</td>
				<td><input type="text" class="k-textbox" style="width: 100%"
					name="title" value=""></td>
				<td>ຫົວຫນ່ວຍ: *</td>
				<td><input id="unit" type="text" style="width: 100%"
					name="unit" value=""></td>

			</tr>

			<tr>
				<td>ຊີມັງ 1(kg): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%" name="cement_1_kg" value="0"></td>
				<td>ສ່ວນປະສົມ ນຳ້ຢາ (cc): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%" name="admixture_1_cc" value="0" ></td>

			</tr>
			
			<tr>
				<td>&bsp;</td>
				<td>&bsp;</td>
				<td>ສ່ວນປະສົມ ນຳ້ຢາ (cc): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%" name="admixture_1_cc" value="0" ></td>

			</tr>


			<tr>
				<td>ຊາຍ (kg): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%"
					name="sand_kg" value="0"></td>
				<td>ສ່ວນປະສົມ ໄທຈິ (cc): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%"
					name="admixture_2_cc" value="0"></td>

			</tr>



			<tr>
				<td>ຫິນຂົບ (kg): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%"
					name="crashed_stone_kg" value="0"></td>
				<td>admixture 3 cc: *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%"
					name="admixture_3_cc" value="0"></td>

			</tr>

			<tr>
				<td>ນຳ້ (litre): *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%"
					name="water_litre" value="0"></td>

				<td>ໜາຍເຫດ:</td>
				<td colspan="3"><input type="text" min="0" class="k-textbox" style="width: 100%"
					name="remark_note" value=""></td>
					

			</tr>

			<tr>
				<td>ລາຄາ: *</td>
				<td><input type="number" min="0" class="numberic" style="width: 100%"
					name="price" value="0"></td>
				<td>ສະກຸນເງິນ: *</td>
				<td><input id="currency" type="text" style="width: 100%"
					name="currency" value=""></td>

			</tr>




			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right"><a href="{{URL::to('product')}}" class="k-button">ກັບຄືນ</a>&nbsp;{{Form::submit('ບັນທຶກ', ['class' => 'k-button
					k-primary'])}}</td>

			</tr>
		</table>
	</div>
</div>

<script>
$(function(){


	// Kendo Numeric Textbox
	$(".numberic").kendoNumericTextBox();
	
	$("#currency").kendoDropDownList({
		dataValueField: "id",
	    dataTextField: "name",
	    autoBind: true,
	    change: function(e) {
	        
			
	    },
	    optionLabel: {
	    	name: '- ເລຶອກສະກຸນເງິນ -',
	        id: ""
	    },
	    dataSource: {
	        transport: {
	            read: {
	            	url: "{{ URL::to('option/json/currency') }}",
	                dataType: "json",
	            }
	        }
	    }
	});


	$("#unit").kendoDropDownList({
		dataValueField: "id",
	    dataTextField: "name",
	    autoBind: true,
	    change: function(e) {
	        
			
	    },
	    optionLabel: {
	    	name: '- ເລຶອກຫົວຫນ່ວບ -',
	        id: ""
	    },
	    dataSource: {
	        transport: {
	            read: {
	            	url: "{{ URL::to('option/json/unit') }}",
	                dataType: "json",
	            }
	        }
	    }
	});



});
</script>
{{Form::close()}} @include('layout.footer')