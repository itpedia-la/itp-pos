@include('layout.header')

<h3>ລາຍການ ການບໍລິການ</h3>
<div align="center">
<hr class="hrHeader"/>
<div class="k-block extended" style="width:80%">

<div class="floatRight">
	<button class="k-button k-primary" id="btnAdd">ເພີ່ມບໍລິການໃໝ່</button> <button class="k-button" id="btnEdit">ແກ້ໄຂຂໍ້ມູນ</button> <button class="k-button" id="btnRemove">ລົບລ້າງ</button>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif


<div id="gridCustList"></div>
</div>
</div>
<script type="text/javascript">

	// Page element initial stage
	
	$("#btnRemove").kendoButton({enable:false});
	$("#btnEdit").kendoButton({enable:false});

	// form Action element reset
	function btnReset() {

		$("#btnEdit").removeData('id');
		$("#btnRemove").removeData('id');
		
		$("#btnEdit").data('kendoButton').enable(false);
		$("#btnRemove").data('kendoButton').enable(false);
		
	}

	// form Action element Set
	function btnSet(id) {

		$("#btnEdit").data('id', id);
		$("#btnRemove").data('id', id);
		
		$("#btnEdit").data('kendoButton').enable(true);
		$("#btnRemove").data('kendoButton').enable(true);

	}
	
	
	
    // Cust Grid Datasource
	var sourceUserList = new kendo.data.DataSource({
		transport: {
	    	read:  {
	           		url: "{{ URL::to('service/json/list') }}",
	                dataType: "json"
	           },
	        },
		pageSize: 10,
	});

	// Cust Grid
	$("#gridCustList").kendoGrid({
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
	    	    { field:"id", title: "ລະຫັດ", width: '10%',},
	    	    { field:"service_name", title: "ລາຍການ", width: '30%', encoded:false },
	    	    { field:"price_html", title: "ລາຄາ / ຫົວໜ່ວຍ", width: '20%', encoded:false },

				{ field:"updated_at", title: "ແກ້ໄຂວັນທີ່", width: '20%', encoded:false },
				{ field:"remark", title: "ໝາຍເຫດ", width: '20%', encoded:false },
				
	        ],
	});

	//  Add
	$("#btnAdd").click(function(e){
		window.location.href="{{ URL::to('service/add') }}";
	});

	// Edit
	$("#btnEdit").click(function(e){
		window.location.href="{{ URL::to('service/edit') }}/"+$(this).data('id');
	});

	$("#btnRemove").click(function(e){
		window.location.href="{{ URL::to('service/remove') }}/"+$(this).data('id');
	});

</script>

@include('layout.footer')