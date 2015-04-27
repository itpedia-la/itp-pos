@include('layout.header')
{{ Form::open(array('url' => 'customer/delete')) }}
<input type="hidden" value="{{ Route::input('cust_id') }}" name="cust_id">
<h3>ລາຍການ ລູກຄ້າ</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:40%">
<b>ລົບລ້າງ ຂໍ້ມູນລູກຂ້າ {{$customer->contact_name}}</b>
<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ຫລືບໍ່?</td>
		</tr>
		<tr>
			<td align="right">
				<button class="k-button" id="btnBack" type="button">ຍົກເລີກ</button> 
				{{Form::submit('ຕົກລົງ', ['class' => 'k-button k-primary'])}}
			</td>
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){
		
		$("#btnBack").click(function(e){
			window.location.href="{{ URL::to('customer') }}";
		});
		
	});
</script>
@include('layout.footer')