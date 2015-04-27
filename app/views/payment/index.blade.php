@include('layout.header')

<h3>ລາຍການ ການຊຳລະເງິນ (Payment)</h3>

<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended" style="width: 70%">
<div class="floatLeft"><a href="#" class="k-button k-primary" onClick="javascript:history.back()">ກັບຄືນ</a></div>
<div class="floatRight">
	 <button class="k-button k-primary" id="btnAdd">ເພີ່ມ ລາຍການຊຳລະເງິນ</button> <button class="k-button" id="btnRemove">ຍົກເລີກ ລາຍການຊຳລະເງິນ</button>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<div id="gridList"></div>
</div>
</div>
<script type="text/javascript">


	var btnAdd =  $("#btnAdd").kendoButton({enable:true}).data('kendoButton');
	var btnRemove = $("#btnRemove").kendoButton({enable:false}).data('kendoButton');

	@if($invoice->status == 3)
	    btnAdd.enable(false);
	@else
		btnAdd.enable(true);
	@endif
	
	// form Action element reset
	function btnReset() {

		$("#btnRemove").removeData('id');
		btnRemove.enable(false);
		
	}

	// form Action element Set
	function btnSet(id) {

		$("#btnRemove").data('id', id);

		btnRemove.enable(true);
	}

    // Cust Grid Datasource
	var sourceUserList = new kendo.data.DataSource({
		transport: {
	    	read:  {
	           		url: "{{ URL::to('transaction/payment/json/list') }}/{{Route::input('invoice_id')}}",
	                dataType: "json"
	           },
	        },
		pageSize: 500,
	});

	//  Grid
	$("#gridList").kendoGrid({
		dataSource: sourceUserList,
		pageable: false,
		selectable: true,
		sortable: true,
		height: 400,
		change: function(e) {
			  grid = e.sender;
			  var selectedValue = grid.dataItem(this.select());
			  btnSet(selectedValue.id);
		},
		filter: true,
	    	columns: [
				{ field:"index", title: "ອດ", width: '10%',},   			
	    	    { field:"id", title: "ລະຫັດ", width: '10%',},
	    	    { field:"invoice_number", title: "ລະຫັດ ໃບຮຽກເກັບເງິນ", width: '20%', encoded:false },
				{ field:"amount", title: "ຈຳນວນເງິນ", width: '20%', encoded:false },
				{ field:"payment_date", title: "ວັນທີຊຳລະ", width: '20%', encoded:false },
				{ field:"updated_at", title: "ວັນທີ", width: '20%', encoded:false },
				{ field:"user", title: "ຮັບເງິນໂດຍ", width: '20%', encoded:false },
	        ],
	});

	//  Add
	$("#btnAdd").click(function(e){
		window.location.href="{{ URL::to('transaction/payment/create') }}/{{Route::input('invoice_id')}}";
	});

	$("#btnRemove").click(function(e){
		window.location.href="{{ URL::to('transaction/payment/remove') }}/"+$(this).data('id');
	});

</script>

@include('layout.footer')
