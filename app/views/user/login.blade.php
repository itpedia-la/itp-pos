@include('layout.header')
<div align="center">
<img src="{{ URL::to('img/logo.png') }}" style="display:block">
<div class="k-block extended auto" style="width: 25%">


 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<span class="tag red"> {{ $error }}</span><br>    
	 @endforeach
 @endif
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
{{ Form::open(array('url' => 'user/login/submit')) }}
<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>ID:</td>
		<td><input type="textbox" class="k-textbox" name="email" id="email" value="{{ Input::get('email') }}" style="width:100%"></td>
	</tr>
	<tr>
		<td>ລະຫັດຜ່ານ:</td>
		<td><input type="password" class="k-textbox" name="password" id="password" style="width:100%"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="right"><button class="k-button k-primary" type="submit">ເຂົ້າສູ່ລະບົບ</button></td>
	</tr>
</table>
</div>
</div>
{{ Form::close() }}
@include('layout.footer')