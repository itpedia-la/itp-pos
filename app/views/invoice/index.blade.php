@include('layout.header')

<h3>ລາຍການ ໃບຮຽກເກັບເງິນ (Invoice)</h3>

<hr class="hrHeader"/>
<div align="center">
<div class="k-block extended" style="width: 100%">
<div class="floatLeft"><a href="#" class="k-button k-primary" onClick="javascript:history.back()">ກັບຄືນ</a></div>
<div class="floatRight">
	 <!--<button class="k-button k-primary" id="btnAdd">ສ້າງ ໃບຮຽກເກັບເງິນ</button>   --><button class="k-button" id="btnInvoiceOut">ອອກ ໃບຮຽກເກັບເງິນ</button> <button class="k-button" id="btnPrint">ພິມໃບຮຽກເກັບເງິນ</button> <button class="k-button" id="btnReceive">ຮັບເງິນ</button> <button class="k-button" id="btnReceipt">ພິມໃບຮັບເງິນ</button> <button class="k-button" id="btnEdit">ແກ້ໄຂ</button> <!-- <button class="k-button" id="btnRemove">ຍົກເລີກ</button> -->
</div>
<div class="ClearFix"></div>
<hr/>
@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
<div id="gridInvoice"></div>
</div>
</div>
<script type="text/javascript">


	var invoice_id = "";
	var customer_id = "";
	
	//var btnAdd 			=  $("#btnAdd").kendoButton({enable:false}).data('kendoButton');
	var btnInvoiceOut 	=  $("#btnInvoiceOut").kendoButton({enable:false}).data('kendoButton');
	var btnPrint 		=  $("#btnPrint").kendoButton({enable:false}).data('kendoButton');
	var btnReceive 		=  $("#btnReceive").kendoButton({enable:false}).data('kendoButton');
	var btnReceipt 		=  $("#btnReceipt").kendoButton({enable:false}).data('kendoButton');
	var btnEdit 		=  $("#btnEdit").kendoButton({enable:false}).data('kendoButton');
	//var btnRemove 		= $("#btnRemove").kendoButton({enable:false}).data('kendoButton');
	
	// form Action element reset
	function btnReset() {

	}

	// form Action element Set
	function btnSet(id, status, amount, customer) {

		invoice_id = id;
		customer_id = customer;

		console.log(status);
		
		if( amount > 0 )
		{
			switch( status ) {

				// 1 waiting for payment
				case 1:
						
					btnInvoiceOut.enable(false);
					btnPrint.enable(true);
					btnReceive.enable(true);
					btnReceipt.enable(false);
					btnEdit.enable(true);
				break;

				// 2 paid
				case 2:

					btnInvoiceOut.enable(false);
					btnPrint.enable(false);
					btnReceive.enable(false);
					btnReceipt.enable(true);
					btnEdit.enable(false);
				break;

				// 3 overdue
				case 3:
					
					btnInvoiceOut.enable(false);
					btnPrint.enable(true);
					btnReceive.enable(false);
					btnReceipt.enable(false);
					btnEdit.enable(false);
					
				break;
				
				// 0 waiting for invoice out
				default:
					btnInvoiceOut.enable(true);
					btnPrint.enable(false);
					btnReceive.enable(false);
					btnReceipt.enable(false);
					btnEdit.enable(false);
				break;
				
			}
		}
	
	}

    // Cust Grid Datasource
	var invoiceSource = new kendo.data.DataSource({
		transport: {
	    	read:  {
	           		url: "{{ URL::to('invoice/get/json/') }}/{{Route::input('transaction_parent_str')}}",
	                dataType: "json"
	           },
	        },
		pageSize: 500,
	});

	//  Grid
	$("#gridInvoice").kendoGrid({
		dataSource: invoiceSource,
		pageable: false,
		selectable: true,
		sortable: true,
		height: 400,
		change: function(e) {
			  grid = e.sender;
			  var selectedValue = grid.dataItem(this.select());
			  
			  btnSet(selectedValue.id, selectedValue.status, selectedValue.amount, selectedValue.customer_id);
		},
		filter: true,
	    	columns: [
	    	   { field:"index", title: "ອດ", width: '5%',},   
	    	    { field:"invoice_number", title: "ເລກທີ", width: '10%', encoded:false },
	    	   // { field:"customer", title: "ລູກຄ້າ", width: '31%', encoded:false },
				
				{ field:"invoice_issue_date", title: "ອອກວັນທີ", width: '12%', encoded:false },
				{ field:"invoice_due_date", title: "ກຳໜົດຊຳລະ ວັນທີ", width: '12%', encoded:false },
				{ field:"invoice_issue_user", title: "ຜູ້ອອກ ໃບຮຽກເກັບເງິນ", width: '15%', encoded:false },
				{ field:"amount_html", title: "ຍອດເງິນຄ້າງ ທີ່ຕ້ອງຊຳລະ", width: '19%', encoded:false },
				{ field:"paid_amount", title: "ຍອດຊຳລະ", width: '12%', encoded:false },
				
				{ field:"invoice_clear_date", title: "ວັນທີ ຊຳລະ", width: '12%', encoded:false },
				{ field:"invoice_clear_user", title: "ຜູ້ຮັບເງິນ", width: '15%', encoded:false },
				{ field:"status_html", title: "ສະຖານະ", width: '16%', encoded:false },
	        ],
	});

	$("#btnInvoiceOut").click(function(e){
		window.location.href="{{ URL::to('invoice/out') }}/"+invoice_id;
	});

	$("#btnEdit").click(function(e){
		window.location.href="{{ URL::to('invoice/edit') }}/"+invoice_id;
	});

	$("#btnPrint").click(function(e){
		
		window.open("{{ URL::to('invoice/print/') }}/"+invoice_id+'/'+customer_id,'_blank');
	});

	$("#btnReceipt").click(function(e){
		
		window.open("{{ URL::to('invoice/print/') }}/"+invoice_id+'/'+customer_id,'_blank');
	});
	

	$("#btnReceive").click(function(e){
		
		window.location.href="{{ URL::to('payment/receive') }}/"+invoice_id;
	});

	$("#btnAdd").click(function(e){
		window.location.href="{{ URL::to('transaction/payment/create') }}/{{Route::input('invoice_id')}}";
	});

	$("#btnRemove").click(function(e){
		window.location.href="{{ URL::to('transaction/payment/remove') }}/"+$(this).data('id');
	});

</script>

@include('layout.footer')
