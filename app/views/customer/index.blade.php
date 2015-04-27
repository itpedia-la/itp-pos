@include('layout.header')

<h3>ລາຍການ ລູກຄ້າ</h3>
<hr class="hrHeader"/>
<div class="k-block extended">

<div class="floatRight">
	<button class="k-button k-primary" id="btnAddCust">ເພີ່ມລູກຄ້າໃຫມ່</button> <button class="k-button" id="btnCustEdit">ແກ້ໄຂຂໍ້ມູນ</button> <button class="k-button" id="btnRemove">ລົບລ້າງ</button>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif


<div id="gridCustList"></div>
</div>
<script type="text/javascript">

	// Page element initial stage
	
	$("#btnRemove").kendoButton({enable:false});
	$("#btnCustEdit").kendoButton({enable:false});

	// form Action element reset
	function btnReset() {

		$("#btnCustEdit").removeData('cust_id');
		$("#btnRemove").removeData('cust_id');
		
		$("#btnCustEdit").data('kendoButton').enable(false);
		$("#btnRemove").data('kendoButton').enable(false);
		
	}

	// form Action element Set
	function btnSet(cust_id) {

		$("#btnCustEdit").data('cust_id', cust_id);
		$("#btnRemove").data('cust_id', cust_id);
		
		$("#btnCustEdit").data('kendoButton').enable(true);
		$("#btnRemove").data('kendoButton').enable(true);

	}
	
	
	
    // Cust Grid Datasource
	var sourceUserList = new kendo.data.DataSource({
		transport: {
	    	read:  {
	           		url: "{{ URL::to('customer/json/list') }}",
	                dataType: "json"
	           },
	        },
		pageSize: 100,
	});

	// Cust Grid
	$("#gridCustList").kendoGrid({
		dataSource: sourceUserList,
		pageable: true,
		selectable: true,
		sortable: true,
		height: 600,
		change: function(e) {
			  grid = e.sender;
			  var selectedValue = grid.dataItem(this.select());

			  btnSet(selectedValue);
		}, 
		filter: true,
	    	columns: [
	    	    { field:"id", title: "ລະຫັດ", width: '5%',},
	    	    { field:"company_name", title: "ບໍລິສັດ", width: '20%', encoded:false },
				{ field:"contact_name", title: "ຊື່ຜູ້ຕິດຕໍ່", width: '20%', encoded:false },
				{ field:"dept_duration", title: "ໄລຍະເວລາຊຳລະ", width: '10%', encoded:false },
				/*{ field:"penalty_fee_m3", title: "ອັດຕາປັບໄຫມ (m3)", width: '10%', encoded:false },*/
				{ field:"overpaid_charge_percentage", title: "ອັດຕາປັບໄຫມ (%)", width: '10%', encoded:false },
				{ field:"mobile", title: "ເບີມືຖື", width: '10%', encoded:false },
				
				
				
				
	        ],
	});

	// Cust Add
	$("#btnAddCust").click(function(e){
		window.location.href="{{ URL::to('customer/add') }}";
	});

	// Edit Edit
	$("#btnCustEdit").click(function(e){
		window.location.href="{{ URL::to('customer/edit') }}/"+$(this).data('cust_id').id;
	});

	$("#btnRemove").click(function(e){
		window.location.href="{{ URL::to('customer/remove') }}/"+$(this).data('cust_id').id;
	});

</script>

@include('layout.footer')