@include('layout.header') {{ Form::open(array('url' =>'product/form/submit')) }}
<input type="hidden" name="product_id" value="{{ Route::input('product_id') }}">
<h3>ລາຍການ ສິນຄ້າ</h3>
<hr class="hrHeader" />
<div align="center">

	<div class="k-block extended auto" style="width:60%">
		<b>ເພິ່ມຂໍ້ມູນສິນຄ້າ</b>

		<hr />
		@if ($errors->has()) @foreach ($errors->all() as $error)
		<div class="message red">
			{{ $error }}<br />
		</div>
		@endforeach @endif
		<!-- <div class="message green">Successfull</div> -->
		<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

			<tr>
				<td colspan="1">ຊື່ສິນຄ້າ: *</td> 
				<td colspan="3"><input type="text" class="k-textbox" name="title" value="{{@$data->title}}" style="width:50%"> <input id="unit" type="text" name="unit"></td>


			</tr>

			<tr>
				<td align="right">Cement 1 (kg):</td>
				<td><input type="text" id="cement_1_kg" name="cement_1_kg" min="0" class="numeric" value="{{@$data->cement_1_kg}}"></td>
				<td align="right">Sand (kg):</td>
				<td><input type="text" id="sand_kg" name="sand_kg" min="0" class="numeric" value="{{@$data->sand_kg}}"></td>
			</tr>
			
			<tr>
				<td align="right">Cement 2 (kg):</td>
				<td><input type="text" id="cement_2_kg" name="cement_2_kg" min="0" class="numeric" value="{{@$data['cement_2_kg']}}"></td>
				<td align="right">Crashed Stone (kg):</td>
				<td><input type="text" id="crashed_stone_kg" name="crashed_stone_kg" min="0"  value="{{@$data['crashed_stone_kg']}}" class="numeric"></td>
			</tr>
			<tr>
				<td align="right">Cement 3 (kg):</td>
				<td><input type="text" id="cement_3_kg" name="cement_3_kg" min="0" class="numeric" value="{{@$data['cement_3_kg']}}"></td>
				<td align="right">Water (litre):</td>
				<td><input type="text" id="water_litre" name="water_litre" min="0" class="numeric" value="{{@$data['water_litre']}}"></td>
			</tr>
			
			
			<tr>
				<td align="right">Cement 4 (kg):</td>
				<td><input type="text" id="cement_4_kg" name="cement_4_kg" min="0" class="numeric" value="{{@$data['cement_4_kg']}}"></td>
				<td align="right">Admixture 1 (cc):</td>
				<td><input type="text" id="admixture_1_cc" name="admixture_1_cc" min="0"  value="{{@$data['admixture_1_cc']}}" class="numeric"></td>
			</tr>
			
			<tr>
				<td align="right">Cement 5 (kg):</td>
				<td><input type="text" id="cement_5_kg" name="cement_5_kg" min="0" class="numeric" value="{{@$data['cement_5_kg']}}"></td>
				<td align="right">Admixture 2 (cc):</td>
				<td><input type="text" id="admixture_2_cc" name="admixture_2_cc" min="0"  value="{{@$data['admixture_2_cc']}}" class="numeric"></td>
			</tr>
			
			<tr>
				<td align="right">Cement 6 (kg):</td>
				<td><input type="text" id="cement_6_kg" name="cement_6_kg" min="0" class="numeric" value="{{@$data['cement_6_kg']}}"></td>
				<td align="right">Admixture 3 (cc):</td>
				<td><input type="text" id="admixture_3_cc" name="admixture_3_cc" min="0"  value="{{@$data['admixture_3_cc']}}" class="numeric"></td>
			</tr>
			
			<tr>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">Price (THB)</td>
				<td><input type="text" id="price" name="price" min="0" class="numeric" value="{{@$data['price']}}"></td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right"><a href="javascript:history.back()" class="k-button">ກັບຄືນ</a> {{Form::submit('ບັນທຶກ', ['class' => 'k-button k-primary'])}}</td>

			</tr>
		</table>
	</div>
</div>

<script>
$(function(){

	
	// Kendo Numeric Textbox
	$(".numeric").kendoNumericTextBox();

	$("#unit").kendoDropDownList({
		dataValueField: "id",
	    dataTextField: "name",
	    autoBind: true,

	    value : '{{ @$data->unit }}',

	    change: function(e) {
	        
			
	    },
	    optionLabel: {
	    	name: '- ເລຶອກຫົວຫນ່ວຍ -',
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
