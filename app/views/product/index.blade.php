@include('layout.header')

<h3>ລາຍການ ສິນຄ້າ</h3>
<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended" style="width: 70%">

<div class="floatRight">
	<button class="k-button k-primary" id="btnAddCust">ເພີ່ມສິນຄ້າໃຫມ່</button> <button class="k-button" id="btnEdit">ແກ້ໄຂຂໍ້ມູນ</button> <button class="k-button" id="btnRemove">ລົບລ້າງ</button>
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif


<div id="gridList"></div>
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
	           		url: "{{ URL::to('product/json/list') }}",
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
	    	    { field:"id", title: "ລະຫັດ", width: '10%',},
	    	    { field:"title", title: "ຊື້ສິນຄ້າ", width: '30%', encoded:false },
				//{ field:"unit", title: "ຫົວຫນ່ວຍ", width: '10%', encoded:false },
				/*{ field:"cement_kg", title: "ຊີມັງ (kg)", width: '10%', encoded:false },
				{ field:"sand_kg", title: "ຊາຍ (kg)", width: '10%', encoded:false },
				{ field:"crashed_stone_kg", title: "ຫິນຂົບ (kg)", width: '10%', encoded:false },
				{ field:"water_litre", title: "ນຳ້ (litre)", width: '10%', encoded:false },
				{ field:"admixture_1_cc", title: "ສ່ວນປະສົມ ນຳ້ຢາ (cc)", width: '10%', encoded:false },
				{ field:"admixture_2_cc", title: "ສ່ວນປະສົມ ໄທຈິ (cc)", width: '10%', encoded:false },
				{ field:"admixture_3_cc", title: "xxx", width: '10%', encoded:false },*/
				{ field:"prict_html", title: "ລາຄາ / ຫົວໜ່ວຍ", width: '15%', encoded:false },
				//{ field:"currency", title: "ສະກຸນເງິນ", width: '15%', encoded:false },
				{ field:"updated_at", title: "ແກ້ໄຂວັນທີ", width: '20%', encoded:false },
	        ],
	});

	//  Add
	$("#btnAddCust").click(function(e){
		window.location.href="{{ URL::to('product/add') }}";
	});

	//  Edit
	$("#btnEdit").click(function(e){
		window.location.href="{{ URL::to('product/edit') }}/"+$(this).data('id');
	});

	$("#btnRemove").click(function(e){
		window.location.href="{{ URL::to('product/remove') }}/"+$(this).data('id');
	});

</script>

@include('layout.footer')
