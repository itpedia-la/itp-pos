@include('layout.header')
{{ Form::open(array('url' => 'transaction_child/remove/submit')) }}
<input type="hidden" value="{{ Route::input('tran_child_id') }}" name="tran_child_id">
<input type="hidden" value="{{ Route::input('tran_parent_id') }}" name="tran_parent_id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">

<b>ລົບລ້າງ ລາຍການ</b>

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
		// Button Back
		$("#btnBack").click(function(e){
			window.location.href="{{ URL::to('transaction') }}";
		});
	});
</script>
@include('layout.footer')