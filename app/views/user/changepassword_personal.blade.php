@include('layout.header')
{{ Form::open(array('url' => 'user/personal/change/password/submit')) }}
<input type="hidden" value="{{ Route::input('user_id') }}" name="user_id">
<h3>ຂໍ້ມູນສ່ວນບຸກຄົນ</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ປ່ຽນລະຫັດຜ່ານ</b>

<hr/>
 @if (Session::get('message'))<div class="message red">{{ Session::get('message') }}<br/></div>@endif
 @if (Session::get('message_success'))<div class="message green">{{ Session::get('message_success') }}<br/></div>@endif
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td>ໃສ່ລະຫັດຜ່ານເກ່ົາ: *</td>
			<td><input type="password" class="k-textbox" style="width:100%" name="current_password" value="{{ Session::get('current_password') }}"></td>
		</tr>
		<tr>
			<td>ໃສ່ລະຫັດຜ່ານໃຫມ່: *</td>
			<td><input type="password"  class="k-textbox" style="width:100%" name="password"></td>
		</tr>
		<tr>
			<td>ໃສ່ລະຫັດຜ່ານໃຫມ່-ອີກຄັ້ງ: *</td>
			<td><input type="password"  class="k-textbox" style="width:100%" name="password_confirmation"></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			
			<td align="right">
			<a class="k-button" href="javascript:history.back()">ຍົກເລີກ</a> 
			{{Form::submit('ບັນທຶກ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){
		
	});
</script>
@include('layout.footer')