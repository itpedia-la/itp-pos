@include('layout.header')

<h3>ລາຍງານ - ລາຍລະອຽດການຂາຍ (Transaction Report)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:100%">
<div class="floatLeft"><form method="get" action="report/">
ຈາກວັນທີ: <input type="text" name="date_start" id="date_start" value="{{ Route::input('date_start') }}"> ເຖີງ <input type="text" name="date_end" id="date_end" value="{{ Route::input('date_end') }}"> <button type="button" id="btnReport" class="k-button k-primary">ຕົກລົງ</button></form>
</div>
<div class="floatRight">
<a class="k-button" href="{{ URL::to('report/transaction/date') }}/{{ Route::input('date_start') }}/{{ Route::input('date_end') }}?print=true" target="_blank">Print</a>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
	<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">
		<!--<tr style="background:#005186; color:#fff">
			<td>ອັນດັບ.:</td>
			<td>ລະຫັດລາຍການຂາຍ</td>
			<td>ລຸກຄ້າ</td>
			<td align="center">ຍອດລວມ</td>
			<td align="center">ຊຳລະແລ້ວ</td>
			<td align="center">ຍອດຄ້າງຊຳລະ</td>
			<td>ວັນທີ:</td>
			<td>ໂດຍ:</td>
		</tr>  -->
		<!--  <tr style="background:#005186; color:#fff">
			<td>ອັນດັບ.:</td>
			<td>ລະຫັດລາຍການຂາຍ</td>
			<td colspan="6">ລຸກຄ້າ</td>
			
		</tr>-->
		@if($data)
		@foreach( $data as $row )
		
		<tr style="background:#005186; color:#fff">
			<td>{{ $row['index'] }}.)</td>
			<td>{{ $row['transaction_number'] }}</td>
            <td colspan="5">{{ $row['customer'] }}</td>
		</tr>
		<tr style="background:#D6D6D6; color:#000">
			<td>ອັນດັບ.:</td>
			<td>ລະຫັດໃບເບີກຈ່າຍສິນຄ້າ</td>
			<td>ສິນຄ້າ</td>
			<td align="center">ຈຳນວນ</td>
			<td align="center">ລາຄາ</td>
			<td align="center">ຍອດລວມ</td>
			<td>ວັນທີ:</td>
			
		</tr>
		
		@foreach( $row['childs'] as $child_row )
		
		@if($child_row['footer'] == false)
		<tr>
			<td>{{ @$child_row['index'] }}</td>
			<td>{{ @$child_row['issue_slip_id'] }}</td>
			<td>{{ @$child_row['title'] }}</td>
			<td align="right">{{ @$child_row['quality'] }}</td>
			<td align="right">{{ @$child_row['price'] }} THB</td>
			<td align="right">{{ @$child_row['total'] }} THB</td>
			<td>{{ @$child_row['issue_date'] }}</td>
			
		</tr>
		@else
		<tr {{ @$child_row['style'] }}>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><u>{{ @$child_row['quality'] }} m<sup>3</sup></u></td>
			<td align="right"><u>ລວມທັງໝົດ:</u></td>
			<td align="right"><u>{{ @$child_row['grand_total'] }} THB</u></td>
			<td>{{ @$child_row['issue_date'] }}</td>
		</tr>
		<tr {{ @$child_row['style'] }}>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><u>ຊຳລະແລ້ວ:</u></td>
			<td align="right"><u>({{ @$child_row['paid'] }} THB)</u></td>
			<td>&nbsp;</td>
		</tr>
		<tr {{ @$child_row['style'] }}>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><u>ຍອດຄ້າງຊຳລະ:</u></td>
			<td align="right"><u>{{ @$child_row['remaining'] }} THB</u></td>
			<td>&nbsp;</td>
		</tr>
		@endif
		
		@endforeach

		@endforeach
		
		<tr style="background:#006600; color:#fff">
			<td colspan="2" align="right">&nbsp;</td>
			<td align="right">ຍອດລວມ (m3):</td>
			<td align="right">{{ $sum['sum_m3'] }}</td>
			<td align="right"><b>ຍອດລວມທັງໝົດ: </b></td>
			<td align="right"><b>{{ $sum['sum_grand_total'] }} THB</b></td>
			<td align="right">&nbsp;</td>
		</tr>
<tr style="background:#006600; color:#fff">
			<td colspan="2" align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><b>ຍອດຊຳລະທັງໝົດ:</b></td>
			<td align="right"><b>({{ $sum['sum_paid'] }} THB)</b></td>
			<td align="right">&nbsp;</td>
		</tr>
		<tr style="background:#006600; color:#fff">
			<td colspan="2" align="right"></td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"><b>ຍອດຄ້າງຊຳລະທັງໝົດ:</b></td>
			<td align="right"><b>{{ $sum['sum_ramaining'] }} THB</b></td>
			<td align="right">&nbsp;</td>
		</tr>
		
		@else
		<tr>
			<td colspan="11" align="center">ຂໍອະໄພ, ບໍ່ພົບຂໍ້ມູນ</td>
		</tr>
		@endif
	</table>
</div>

</div>

<script type="text/javascript">
	$(document).ready(function(e){
		
		$("#date_start").kendoDatePicker({
			format : "dd-MMM-yyyy"
		});

		$("#date_end").kendoDatePicker({
			format : "dd-MMM-yyyy"
		});

		$("#btnReport").click(function(e){
			e.preventDefault();
			window.location.href = "{{ URL::to('/report/transaction') }}/date/"+$("#date_start").val()+'/'+$("#date_end").val();
		});
	});
</script>
@include('layout.footer')