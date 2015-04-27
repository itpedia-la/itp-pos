@include('layout.header')

<h3>ລາຍລະອຽດ ການຂາຍ ແລະ ການຊຳລະເງິນ (Transaction and Payment Report)</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended auto" style="width:100%">
<div class="floatLeft"><form method="get" action="report/">
ປະຈຳເດືອນ: <input type="text" name="month" id="month" value="{{ Route::input('month') }}"> <button type="button" id="btnReport" class="k-button k-primary">ຕົກລົງ</button></form>
</div>
<div class="floatRight">
<a class="k-button" href="{{ URL::to('report/transaction/month') }}/{{ Route::input('month') }}?print=true" target="_blank">Print</a>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
	<table class="tableStylingReport" cellpadding="0" cellspacing="0" width="100%">

		<tr style="background:#278BCB; color:#fff">
			<td colspan="2" align="center">ລາຍການລູກຄ້າ/ ລະຫັດ ລາຍການຂາຍ</td>
            <td align="center">ລະຫັດໃບຮຽກເກັບເງິນ / ສະຖານທີ່ສົ່ງ</td>
            <td align="center">ລວມ m<sup>3</sup></td>
            <td align="center">ລວມ ເງິນທັງໝົດ</td>
            <td align="center">ລວມ ຍອດເງິນຊຳລະແລ້ວ</td>
            <td align="center">ລວມ ຍອດເງິນຄ້າງຊຳລະ</td>
            <td align="center">ວັນທີ</td>
		</tr>
		@if(@$data)
		
		@foreach( array_slice($data,0,-1) as $row )
		@if(@$row['customer']!="")
		<tr style="background:#A8DFF4; color:#000">
			<td colspan="2">{{ $row['index'] }}.) {{ @$row['customer'] }}</td>
            <td>{{ $row['invoice_number'] }}</td>
            <td align="right">{{ @$row['sum_m3'] }}</td>
            <td align="right">{{ @$row['sum_grand_total_all'] }}</td>
            <td align="right">{{ @$row['invoice_paid'] }}</td>
            <td align="right">{{ @$row['invoice_remain'] }}</td>
            <td align="right">{{ @$row['invoice_status_html'] }}</td>
		</tr>
		@else
		<tr style="background:#FFF6DF; font-weight:bold; color:#000">
			<td align="right">{{ @$row['index'] }}.)</td>
            <td>{{ @$row['id'] }}</td>
            <td>{{ @$row['send_location'] }}</td>
            <td align="right">{{ @$row['sum_m3_child'] }}</td>
            <td align="right">{{ @$row['grand_total_html'] }}</td>
            <td align="right">{{ @$row['invoice_remain'] }}</td>
            <td align="right">{{ @$row['invoice_status_html'] }}</td>
            <td>{{ @$row['transaction_date'] }}</td>
		</tr>
		@if( @$row['transaction_childs'] )
		@foreach( $row['transaction_childs'] as $child)
			<tr >
			<td>&nbsp;</td>
            <td>{{ $child['issue_slip_id'] }}</td>
            <td>{{ $child['title'] }}</td>
            <td align="right">{{ @$child['quality'] }}</td>
            <td align="right">{{ @$child['total'] }} THB</td>
            <td align="right">{{ @$row['invoice_remain'] }}</td>
            <td align="right">&nbsp;</td>
            <td>{{ @$child['issue_date'] }}</td>
		</tr>
		@endforeach
		@endif
		@endif
		@endforeach
		<tr style="background:#278BCB; color:#fff">
			<td colspan="2" align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">ລວມ m<sup>3</sup></td>
            <td align="center">ລວມ ເງິນທັງໝົດ</td>
            <td align="center">ລວມ ຍອດເງິນຊຳລະແລ້ວ</td>
            <td align="center">ລວມ ຍອດເງິນຄ້າງຊຳລະ</td>
            <td align="center">&nbsp;</td>
		</tr>
		<tr style="background:#278BCB; color:#fff; font-weight:bold">
			<td colspan="2" align="center">&nbsp;</td>
            <td align="right">ຍອດລວມປະຈຳເດືອນ:</td>
            <td align="center">{{ @end($data)['grand_sum_m3'] }} m<sup>3</sup></td>
            <td align="center">{{ @end($data)['grand_sum_total'] }} THB</td>
            <td align="center">{{ @end($data)['grand_sum_paid'] }} THB</td>
            <td align="center">{{ @end($data)['grand_sum_remain'] }} THB</td>
            <td align="center">&nbsp;</td>
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
		
		$("#month").kendoDatePicker({
	        start: "year",
	        depth: "year",
	        format: "MMMM yyyy",
	        /*change : function() {
	        	window.location.href = "{{ URL::to('/report/transaction') }}/month/"+$("#month").val();
	        }*/
		});

		$("#btnReport").click(function(e){
			e.preventDefault();
			window.location.href = "{{ URL::to('/report/transaction') }}/month/"+$("#month").val();
		});
	});
</script>
@include('layout.footer')