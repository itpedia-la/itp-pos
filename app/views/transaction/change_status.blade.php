@include('layout.header')
{{ Form::open(array('url' => 'transaction/change_status/submit')) }}
<input type="hidden" value="{{ Route::input('tran_parent_id') }}" name="tran_parent_id">
<h3>ລາຍການຂາຍ (Transaction)</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">

<b>ໂອນ ໃບສະເຫນີລາຄາ ເປັນ  ລາຍການຂາຍ</b>

<hr/>
 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
	
			<td>ທ່ານຕ້ອງການໂອນ ໃບສະເຫນີລາຄາ ເປັນ ລາຍການຂາຍ ຫລືບໍ່?</td>
		</tr>

		<tr>
			
			<td><input type="text" name="due_paid_at" placeholder="ກຳຫນົດຊຳລະວັນທີ່..." id="due_paid_at" value="{{ date('d-M-Y',strtotime('+'.$dept_duration.' days')) }}"> ( ກຳໜົດຊຳລະພາຍໃນ {{ $dept_duration }} ວັນ )</td>
		</tr>
		
		<tr>
	
			<td align="right">
				<a class="k-button" href="javascript:history.back()">ຍົກເລີກ</a> 
			{{Form::submit('ຕົກລົງ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){

		var due_paid_at = $("#due_paid_at").kendoDatePicker({
			format : "dd MMM yyyy"
		}).data('kendoDatePicker');
		
		// Button Back
		$("#btnBack").click(function(e){
			window.location.href="{{ URL::to('transaction/') }}";
		});
	});
</script>
@include('layout.footer')