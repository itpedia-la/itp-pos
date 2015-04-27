<p><b>ລາຍການປັບໄຫນລູກຄ້າ ຄ້າງຊຳລະປະຈຳວັນທີ: {{ date('d-M-Y') }}</b></p>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
	<tr>
		<th>ບໍລິສັດ / ລູກຄ້າ</th>
		<th>ປະເພດລູກຄ້າ</th>
		<th>ລະຫັດການຂາຍ</th>
		<th>ລາຍການ</th>
		<th>ຈຳນວນ</th>
		<th>ຄ່າປັບໄຫມ</th>
		<th>ປັບໄຫມຄັ້ງຕໍ່ໄປ</th>
	</tr>

	@foreach( $result as $value )
	<tr>
		<td>{{ $value['customer_name'] }}</td>
		<td>{{ $value['customer_type'] }}</td>
		<td>{{ $value['transaction_parent_id'] }}</td>
		<td>{{ $value['title'] }}</td>
		<td align="right">{{ $value['amount'] }}</td>
		<td align="right">{{ $value['penalty_cost'] }}</td>
		<td>{{ $value['next_penalty_date'] }}</td>
	</tr>
	@endforeach
</table>