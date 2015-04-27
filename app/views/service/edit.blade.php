@include('layout.header')
{{ Form::open(array('url' => 'service/update')) }}
{{Form::hidden('service_id',$service->id)}}

<h3>ລາຍການ ການບໍລິການ</h3>
<hr class="hrHeader"/>

<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ແກ້ໄຂຂໍ້ມູນບໍລິການໃຫມ່</b>

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
			<td><input type="text" class="k-textbox" style="width:100%" name="service_name" value="{{$service->service_name}}"></td>
		</tr>
		<tr>
			<td>ລາຄາ: *</td>
			<td><input type="number" class="numberic" style="width:100%" name="price" value="{{$service->price}}"></td>
		</tr>
		<!-- <tr>
			<td>ສະກຸນເງິນ: *</td>
			<td><input id="currency" type="text" style="width:100%" name="currency" value="{{$service->currency}}"></td>
		</tr> -->
		<tr>
			<td>ຫົວໜ່ວຍ: *</td>
			<td><input id="unit" type="text" style="width:100%" name="unit" value="{{$service->unit}}"></td>
		</tr>
		<tr>
			<td>ໝາຍເຫດ: </td>
			<td><input type="text" class="k-textbox" style="width:100%" name="remark" value="{{$service->remark}}"></td>
		</tr>

		
		
		
		
		
		<tr>
			<td>&nbsp;</td>
			
			<td align="right">
	
			<a href="{{URL::to('service')}}" class="k-button">ກັບຄືນ</a>&nbsp;{{Form::submit('ບັນທຶກ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">

	$(document).ready(function(e){
		$(".numberic").kendoNumericTextBox();


		
		$("#unit").kendoDropDownList({
			dataValueField: "id",
		    dataTextField: "name",
		    autoBind: true,
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
@include('layout.footer')