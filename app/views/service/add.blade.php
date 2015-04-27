@include('layout.header')
{{ Form::open(array('url' => 'service/save')) }}

<h3>ລາຍການ ການບໍລິການ</h3>
<hr class="hrHeader"/>

<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ເພິ່ມຂໍ່ມູນບໍລິການໃຫມ່</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
<!-- <div class="message green">Successfull</div> -->
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
	
		<tr>
			<td>ຊື່ບໍລິການ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="service_name" value=""></td>
		</tr>
		<tr>
			<td>ລາຄາ: *</td>
			<td><input type="number" class="numberic" style="width:100%" name="price" value="0"></td>
		</tr>
		
		<!-- <tr>
			<td>ສະກຸນເງິນ: *</td>
			<td><input id="currency" type="text" style="width:100%" name="currency"></td>
		</tr> -->
		<tr>
			<td>ຫົວໜ່ວຍ: *</td>
			<td><input id="unit" type="text" style="width:100%" name="unit"></td>
		</tr>
		<tr>
			<td>ໝາຍເຫດ: </td>
			<td><input type="text" class="k-textbox" style="width:100%" name="remark"></td>
		</tr>

		
		
		
		
		
		<tr>
			<td>&nbsp;</td>
			
			<td align="right">
	
			<a href="{{URL::to('service')}}" class="k-button">ກັບຄືນ</a>&nbsp;{{Form::submit('ເພີ່ມ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">

	 
	$(document).ready(function(e){

		
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
@include('layout.footer')