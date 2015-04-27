@include('layout.header')
{{ Form::open(array('url' => 'transaction_invoice_penalty/remove/submit')) }}
<input type="hidden" value="{{ Route::input('id') }}" name="id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">

<b>ຍົກເລີກ ລາຍການປັບໄຫມ</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
	
			<td>ທ່ານຕ້ອງການຍົກເລີກ ລາຍການ ນີ້ ຫລືບໍ່?</td>
		</tr>

		<tr>
	
			<td align="right">
				<a class="k-button" href="javascript:history.back(-1)">ຍົກເລີກ</a> 
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

	});
</script>
@include('layout.footer')