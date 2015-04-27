@include('layout.header')
{{ Form::open(array('url' => 'profile/update')) }}
{{ Form::hidden('profile_id',$profile->id)}}
{{ Form::hidden('logo',$profile->logo)}}
<h3>ຕັ້ງຄ່າທົ່ວໄປ</h3>
<hr class="hrHeader"/>
<div align="center">

<div class="k-block extended auto" style="width:40%">
<b>ຂໍ້ມູນບໍລິສັດ</b>

<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif

 @if ($errors->has())
	 @foreach ($errors->all() as $error)
		<div class="message red">{{ $error }}<br/></div>
	 @endforeach
 @endif
<!-- <div class="message green">Successfull</div> -->
	<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">
	
		<tr>
			<td>ຊື່ບໍລິສັດ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="company_name" value="{{$profile->company_name}}"></td>
		</tr>
		
		<!-- <tr>
			<td>Logo: *</td>
			<td><img width="100" src="{{URL::to('img',array('image'=>$profile->logo))}}"/>
			
			<input id="file_upload" type="file" class="k-textbox" style="width:100%" name="logo" value="{{$profile->logo}}"></td>
		</tr> -->
		<tr>
			<td>ທີ່ຢູ່: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="address" value="{{$profile->address}}"></td>
		</tr>
		<tr>
			<td>ເບີໂທ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="telephone" value="{{$profile->telephone}}"></td>
		</tr>
		
		<tr>
			<td>ເບີມືຖື: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="mobile" value="{{$profile->mobile}}"></td>
		</tr>
		
		<tr>
			<td>ແຟັກ: </td>
			<td><input type="text" class="k-textbox" style="width:100%" name="fax" value="{{$profile->fax}}"></td>
		</tr>
		
		<tr>
			<td>ອີເມວລ: *</td>
			<td><input type="text" class="k-textbox" style="width:100%" name="email" value="{{$profile->email}}"></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			
			<td align="right">
	
			{{Form::submit('ບັນທືກ', ['class' => 'k-button k-primary'])}}
	
			</td>
			
		</tr>
	</table>
</div>
</div>
{{Form::close()}}
<script type="text/javascript">
	$(document).ready(function(e){
		
		 $("#file_upload").kendoUpload();
	});
</script>
@include('layout.footer')