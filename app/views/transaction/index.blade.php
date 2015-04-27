@include('layout.header')
<style>
<!--

#gridTransactionList .k-grid-header
{
    height: 0;
    border-bottom-width: 0;
    display: none;
    overflow: hidden;
}
.tdWidth { width:2000px }
tr.header td {
	
  border-top:1px solid #000;
border-bottom:1px solid #DBDBDE;
color:#000;
cursor: pointer;
}

.sHr { border-top:none; border-left:none; border-right:none; border-bottom:1px dotted #c1c1c1; margin:0px; padding:0px }
-->
</style>
<h3>ລາຍການຂາຍ (Transaction)</h3>

		 <div class="k-block extended">
			<div class="floatLeft">
				<input type="text" id="month" value="{{ date('F Y') }}"> <!-- <input type="text" id="date_start" value="{{ date('01-M-Y') }}"> <input type="text" id="date_start" value="{{ date('01-M-Y') }}"> <input type="text" id="date_end" value="{{ date('t-M-Y') }}"> <button class="k-button k-primary" id="btnOk">ສະແດງລາຍການ</button>-->
			</div>
			<div class="floatRight">
				<a class="k-button k-primary" href="{{ URL::to('transaction/add/1') }}" id="btnCreateTransaction">ສ້າງລາຍການຂາຍ</a>
				<button class="k-button" id="btnInvoiceList">ລາຍການ ໃບຮຽກເກັບເງິນ</button>
				<!-- <button class="k-button" id="btnPrintInvoice">ພິມ "ໃບຮຽກເກັບເງິນ"</button> -->
				<!--<button class="k-button" id="btnPayment">ລາຍການ ການຊຳລະເງິນ</button>-->
				<button class="k-button" id="btnCancel">ຍົກເລີກ ລາຍການຂາຍ</button>

			</div>
			<div class="ClearFix"></div>
			
			<hr/>
			@if( Session::get('message') ) <div class="message green">{{ Session::get('message') }}</div>@endif
			<div id="gridTransactionList"></div>
			<script id="rowTemplateHeader" type="text/x-kendo-tmpl">
                
                # if (customer!=0) { #
                
                <tr class="header">
		            <td align="left"style="width:280px" colspan="2">#= penalty# <b>#= customer#</b></td>
                    <td align="left" style="width:180px">#= invoice_number#</td>
					<td align="right" style="width:80px">#= sum_m3#</td>
					<td align="right" style="width:130px">#= sum_grand_total_all#</td>
					<td style="width:130px" align="right">#= invoice_paid#</td>
					<td style="width:130px" align="right">#= invoice_remain#</td>
					<td style="width:110px" align="right">#= invoice_status_html#</td>
	            </tr>
     
                # } else { #
                <tr>
					<td align="right">ລະຫັດ:</td>
		            <td>#= id#</td>
                    <td>#= send_location#</td>
                    <td align="right">#= sum_m3_child#</td>
                    <td align="right">#= grand_total_html#</td>
                    <td></td>
					<td align="right">#= transaction_date#</td>
                    <td align="right">&nbsp;</td>
	            </tr>
                # }  #

            </script>

			</div>


			<div class="k-block extended" style="margin-top:10px">
			<div class="floatLeft">
				
			</div>
			<div class="floatRight">
				
				
			</div>
			<div class="ClearFix"></div>
		
			@if( Session::get('message_child') ) <div class="message green">{{ Session::get('message_child') }}</div>@endif
			


							<div class="floatLeft"><input type="text" class="k-textbox" id="txtRemark" placeholder="ໝາຍເຫດ..." style="width:500px"></div>
							<div class="floatRight">
	                                	<button id="btnChildProductAdd" class="k-button k-primary">ເພີ່ມ ລາຍການ ສິນຄ້າ</button>
	                                	<button id="btnChildServiceAdd" class="k-button k-primary">ເພີ່ມ ລາຍການ ບໍລິການ</button>
	                                	<button id="btnChildEdit" class="k-button">ແກ້ໄຂ</button>
	                                	<button id="btnChildCancel" class="k-button">ຍົກເລີກ</button>
	                                </div>
	                                <div class="ClearFix"></div>
                                	<hr/>
                               	
                                    <div id="gridTransactionChildList"></div>
                       
               </div>         
      
<script type="text/javascript">

$(document).ready(function(){


   /* $("#date_start").kendoDatePicker({
        format : "MMM-yyyy"
    });
    
    $("#date_end").kendoDatePicker({
        format : "dd-MMM-yyyy"
    });*/

	var btnCancel = $("#btnCancel").kendoButton({enable:false}).data('kendoButton');
	//var btnPrintInvoice = $("#btnPrintInvoice").kendoButton({enable:false}).data('kendoButton');
	var btnPayment = $("#btnPayment").kendoButton({enable:false}).data('kendoButton');
	var btnInvoiceList = $("#btnInvoiceList").kendoButton({enable:false}).data('kendoButton');
	
	$("#overpaid_charge_percentage").kendoNumericTextBox();
	$("#dept_duration").kendoNumericTextBox();

	
	var btnChildProductAdd 	= $("#btnChildProductAdd").kendoButton({enable:false}).data('kendoButton');
	var btnChildCancel 		= $("#btnChildCancel").kendoButton({enable:false}).data('kendoButton');
	var btnChildEdit 		= $("#btnChildEdit").kendoButton({enable:false}).data('kendoButton');
	var btnChildServiceAdd 	= $("#btnChildServiceAdd").kendoButton({enable:false}).data('kendoButton');

	$("#month").kendoDatePicker({
        start: "year",
        depth: "year",
        format: "MMMM yyyy",
        change : function() {
	          
        	var grid = $("#gridTransactionList").data("kendoGrid");
	        grid.dataSource.transport.options.read.url = "{{ URL::to('transaction/json/list') }}/"+encodeURIComponent($("#month").val());
	        grid.dataSource.read(); 
        }
	});
	
	// form Action element reset
	function btnReset() {

		$("#btnChildCancel").removeData('tran_child_id');
		$("#btnChildCancel").removeData('tran_parent_id');
		$("#btnChildEdit").removeData('tran_child_id');
		$("#btnChildEdit").removeData('tran_parent_id');
		$("#btnChildCancel").data('kendoButton').enable(false);
		$("#btnChildEdit").data('kendoButton').enable(false);
	}

	// form Action element Set
	function btnSet(tran_child_id, tran_parent_id, penalty) {

		$("#btnChildCancel").data('penalty',penalty);
		$("#btnChildEdit").data('tran_child_id',tran_child_id);
		$("#btnChildEdit").data('tran_parent_id',tran_parent_id);
		$("#btnChildCancel").data('tran_child_id',tran_child_id);
		$("#btnChildCancel").data('tran_parent_id',tran_parent_id);
		
		if( penalty == 1 ) {

			$("#btnChildEdit").data('kendoButton').enable(false);
			$("#btnChildCancel").data('kendoButton').enable(false);
			
		} else {
		
			$("#btnChildCancel").data('kendoButton').enable(true);
			
			
			$("#btnChildEdit").data('kendoButton').enable(true);
			
		}

	}


	// Add button click
	$("#btnChildAdd").click(function(e){
		e.preventDefault();
		window.location.href= 'transaction_child/add/'+$(this).data('transaction_parent_id');
	});

	// form Action element reset
	function btnTranChildReset() {

		$("#btnChildProductAdd").removeData('tran_parent_id');
		$("#btnChildServiceAdd").removeData('tran_parent_id');
		
		btnChildProductAdd.enable(false);
		btnChildProductAdd.enable(false);
		
	}

	// form Action element Set
	function btnTranChildSet( header, transaction_parent_id, customer_id, invoice_status, transaction_parent_str, invoice_id ) {

		console.log(header);
		console.log(invoice_status);
		console.log(transaction_parent_str);

		$("#btnChildProductAdd").data('tran_parent_id',transaction_parent_id);
		$("#btnChildServiceAdd").data('tran_parent_id',transaction_parent_id);
		
		$("#btnInvoiceList").data('transaction_parent_str',transaction_parent_str);
		$("#btnInvoiceList").data('customer_id',customer_id);
		
		$("#btnCancel").data('tran_parent_id',transaction_parent_id);
		
		// header true, invoice_status "waiting issue invoice - 0"
		if( header == 1 && invoice_status == 0 ) {

			btnInvoiceList.enable(true);
			btnChildProductAdd.enable(false);
			btnChildServiceAdd.enable(false);
			btnCancel.enable(false);
			
			// header "1", invoice_status "waiting payment - 1"
		} else if(  header == 1 && invoice_status == 1 ) {

			btnInvoiceList.enable(true);
			btnCancel.enable(false);
			btnChildProductAdd.enable(false);
			btnChildServiceAdd.enable(false);
			
		// header "1", invoice_status "paid - 2"
		} else if(  header == 1 && invoice_status == 2 ) {

			btnInvoiceList.enable(true);
			btnCancel.enable(false);
			btnChildProductAdd.enable(false);
			btnChildServiceAdd.enable(false);

		// header "1", invoice_status "overpaid - 3"
		} else if(  header == 1 && invoice_status == 3 ) {

	
			btnInvoiceList.enable(false);
			btnCancel.enable(false);
			btnChildProductAdd.enable(false);
			btnChildServiceAdd.enable(false);

		} else if(  header == 0 && invoice_status == 0 ) {

			btnInvoiceList.enable(false);
			btnCancel.enable(true);
			btnChildProductAdd.enable(true);
			btnChildServiceAdd.enable(true);

		} else {
			
			btnInvoiceList.enable(false);

			// Transaction Parent Cancel Button
			btnCancel.enable(true);

			// Transaction Child Buttons
			btnChildProductAdd.enable(true);
			btnChildServiceAdd.enable(true);

		}

	}

	// Add Product button click
	$("#btnChildProductAdd").click(function(e){
		e.preventDefault();
		var tranIdx = $(this).data('tran_parent_id');
		
		//window.location.href= 'transaction_child/product/add/'+$(this).data('tran_parent_id');
		var windowDialog = document.createElement('div');
		windowDialog.id = 'windowDialog';
		document.body.appendChild(windowDialog);

		var windowDialog = $("#windowDialog").kendoWindow({

	        title: false,
	        visible: false,
	        animation: false,
	        modal: true,
	        width: 400,
	        resizable: false,
	        draggable: true,
	        close: function() { this.destroy(); $("#windowDialog").remove() },
        
		}).data("kendoWindow");

		var content = '<table class="tableStyling" cellpadding="0" cellspacing="0" width="100%">';
		     content+= '<tr>';
		      content+= '<td align="right"><input name="product_id" id="product_id" style="width:100%"></td>';
		     content+= '</tr>';
		     content+= '<tr>';
		      content+= '<td align="right">BF: <input type="text" name="issue_slip_id" placeholder="ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ..." id="issue_slip_id" class="k-textbox" value="" style="width:80%"></td>';
		     content+= '</tr>';
		     content+= '<tr>';
		      content+= '<td align="right"><input type="text" name="quality" placeholder="ຈຳນວນ..." id="quality" value="" style="width:80%" min="0" step="0.50"> m<sup>3</sup></td>';
		     content+= '</tr>';
		     content+= '<tr>';
		      content+= '<td align="right"><input type="text" name="issue_date" placeholder="ວັນທີເບີກຈ່າຍສິນຄ້າ..." id="issue_date" value="" style="width:50%"> <input type="text" id="HH" name="HH" style="width:80px" max="24">:<input type="text" id="MM" name="MM" max="59" style="width:80px"></td>';
		     content+= '</tr>';
		     content+= '<tr>';
		      content+= '<td align="right">FMG-<input type="text" name="truck_number" placeholder="ທະບຽນລົດ..." class="k-textbox" id="truck_number" style="width:70%" min="0"></td>';
		     content+= '</tr>';
		     content+= '<tr>';
		      content+= '<td align="right"><textarea class="k-textbox" placeholder="ຫມາຍເຫດ..." style="width:100%" name="remark" id="remark"></textarea></td>';
		     content+= '</tr>';
		     content+= '<tr>';
		      content+= '<td align="right"><button class="k-button k-primary" id="btnSubmit">ບັນທຶກ</button> <button class="k-button" id="btnClose">ປິດ</button></td>';
		     content+= '</tr>';
		    content+= '</table>';

		windowDialog.content(content);
		windowDialog.center().open();

		$("#btnClose").click(function(){
		    windowDialog.close();
		});

		var quality = $("#quality").kendoNumericTextBox().data('kendoNumericTextBox');
		var HH = $("#HH").kendoNumericTextBox({
				format: "n0"
			}).data('kendoNumericTextBox');
		var MM = $("#MM").kendoNumericTextBox({
			format: "n0"
		}).data('kendoNumericTextBox');
		
		var issue_date = $("#issue_date").kendoDatePicker({
			format : "dd-MMM-yyyy",
			change: function() {
				HH.focus();
			   // $("#truck_number").focus();
			}
		}).data('kendoDatePicker');

		var ProductSource = new kendo.data.DataSource({
			transport: {
		    	read:  {
		           		url: "{{ URL::to('product/json/list') }}",
		                dataType: "json"
		           },
		        },
			pageSize: 100,
		});
	
    	var product_combobox = $("#product_id").kendoComboBox({
            dataTextField: "title_html",
            dataValueField: "id",
            dataSource: ProductSource,
            filter: "contains",
            suggest: true,
            value: ' ',
            index: 5,
            change : function() {
              $("#issue_slip_id").focus();
            }
       }).data('kendoComboBox');

    	$('#issue_slip_id').keydown(function (e) {
   	     if (e.which === 13) {
   		  quality.focus();
   	     }
   	   });

    	 $('#HH').keydown(function (e) {
    	     if (e.which === 13) {
    		   MM.focus();
    	     }
    	 });

    	 $('#MM').keydown(function (e) {
    	     if (e.which === 13) {
    	    	$("#truck_number").focus();
    	     }
    	 });
    	 
    	 $('#quality').keydown(function (e) {
    	     if (e.which === 13) {
    		   issue_date.open();
    	     }
    	 });

    	$('#truck_number').keydown(function (e) {
   	     if (e.which === 13) {
   		   $("#remark").focus();
   	     }
   	   });

    	$('#remark').keydown(function (e) {
  	     if (e.which === 13) {
  		   $("#btnSubmit").focus();
  	     }
  	   });

	   $("#btnSubmit").click(function(e){
		   e.preventDefault();
	       $.ajax({
		      url : '{{ URL::to("transaction_child/ajax/product/submit") }}',
		      type : 'post',
		      dataType : 'json',
		      data : { 'tran_parent_id' : tranIdx, 'quality' : quality.value(),'product_id' : product_combobox.value(), 'issue_slip_id' : $('#issue_slip_id').val(), 'truck_number' : $("#truck_number").val(), 'issued_date' : $("#issue_date").val(), 'HH' : $("#HH").val(), 'MM' : $("#MM").val(),'remark' : $("#remark").val() },
		      success : function(returnData) {
			    if(returnData.fail==true) {
				   alert(returnData.errors);
			    } else {

				    var grid = $("#gridTransactionList").data("kendoGrid");
			        
			          grid.dataSource.read();


			          var grid = $("#gridTransactionChildList").data("kendoGrid");
			          grid.dataSource.read(); 


			          $('#issue_slip_id').val("");
			          $('#truck_number').val("");
			          //$('#issued_date').val("");
			          $('#remark').val("");
			          quality.value("");
			          HH.value("");
			          MM.value("");
			          product_combobox.value('');
			          product_combobox.focus();
			    }
			  }
		   });
		});
    	
        product_combobox.focus();

	});

	// Add Serivce button click
	$("#btnChildServiceAdd").click(function(e){
		e.preventDefault();
		window.location.href= 'transaction_child/service/add/'+$(this).data('tran_parent_id');
	});

	// CAnncel button click
	$("#btnChildCancel").click(function(e){
		e.preventDefault();

		var penalty = $(this).data('penalty');

		/*if( penalty == 1 ) {
			
			window.location.href= 'transaction_invoice_penalty/remove/'+$(this).data('tran_child_id');
			
		} else {

			window.location.href= 'transaction_child/remove/'+$(this).data('tran_parent_id')+'/'+$(this).data('tran_child_id');

		}*/

		window.location.href= 'transaction_child/remove/'+$(this).data('tran_parent_id')+'/'+$(this).data('tran_child_id');

	});

	// Edit button click
	$("#btnChildEdit").click(function(e){
		e.preventDefault();

		window.location.href= 'transaction_child/edit/'+$(this).data('tran_parent_id')+'/'+$(this).data('tran_child_id')+'/0';
	});

	$("#mnToInvoice").click(function(e){
		e.preventDefault();
		if( $(this).data('tran_status') == 0 ) {
			window.location.href= 'transaction/change_status/'+$(this).data('tran_parent_id');
		}
	});

	$("#btnCancel").click(function(e){
		e.preventDefault();
		window.location.href= 'transaction/cancel/'+$(this).data('tran_parent_id');
	});

	$("#mnPaid").click(function(e){
		e.preventDefault();
		
		if ( $(this).data('tran_parent_id') > 0 && ( $(this).data('tran_status') == 1 || $(this).data('tran_status') == 2) ) {
			window.location.href= 'transaction/payment/'+$(this).data('tran_parent_id');
		}
	});

	$("#btnInvoiceList").click(function(e){
		e.preventDefault();
		window.location.href = 'invoice/'+$(this).data('transaction_parent_str');
	
	});
	
	/*$("#btnPrintInvoice").click(function(e){
		e.preventDefault();
		window.open('transaction/custom/invoice/print/'+$(this).data('invoice_id')+'/'+$(this).data('customer_id')+'/'+$("#month").val(),'_blank');
	});*/

	$("#btnPayment").click(function(e){
		e.preventDefault();
		window.location.href = 'transaction/payment/'+$(this).data('invoice_id');
	});


	$("#btnPaymentCancel").click(function(e){
		e.preventDefault();
		if ( $(this).data('tran_payment_id') > 0 ) {
		window.location.href= 'transaction/payment/cancel/'+$(this).data('tran_payment_id');
		}
	});

	$("#btnPaymentPrint").click(function(e){
		e.preventDefault();
		
		if ( $(this).data('tran_payment_id') > 0 ) {
		window.open('transaction/payment/print/'+$(this).data('tran_payment_id')+'/'+$(this).data('tran_parent_id'),'_blank');
		}
	});

	$("#btnOk").click(function(e){
		e.preventDefault();
	    var grid = $("#gridTransactionList").data("kendoGrid");
	        grid.dataSource.transport.options.read.url = "{{ URL::to('transaction/json/list/') }}/"+$("#date_start").val()+'/'+$("#date_end").val();
	        grid.dataSource.read();
	        
	});
	
    // Grid Datasource
	var sourceTransactionParent = new kendo.data.DataSource({
		transport: {
	    	read:  {
	    			url: "{{ URL::to('transaction/json/list') }}/"+encodeURIComponent($("#month").val()),
	           		//url: "{{ URL::to('transaction/json/list') }}/"+encodeURIComponent($("#month").val())+'/'+encodeURIComponent($("#date_end").val()),
	                dataType: "json"
	           },
	        },
		pageSize: 500,
	});

	// Transaction Grid
	$("#gridTransactionList").kendoGrid({
		dataSource: sourceTransactionParent,
		pageable: false,
		selectable: true,
		sortable: true,
		height: 400,
		change: function(e) {
			  grid = e.sender;
			  var selectedValue = grid.dataItem(this.select());

			  btnTranChildSet(selectedValue.header, selectedValue.id, selectedValue.customer_id, selectedValue.invoice_status, selectedValue.transaction_parent_str, selectedValue.invoice_id);
			  btnReset();
			  
			  var grid = $("#gridTransactionChildList").data("kendoGrid");
	          grid.dataSource.transport.options.read.url = "{{ URL::to('transaction_child/json/list') }}/"+selectedValue.id+'/'+selectedValue.transaction_parent_str;
	          grid.dataSource.read(); 
	       
		}, 
		rowTemplate: kendo.template($("#rowTemplateHeader").html()),
	});
	
	// Grid Child Datasource
	var sourceTransactionChild = new kendo.data.DataSource({
		transport: {
	    	read:  {
	           		url: "{{ URL::to('transaction_child/json/list/') }}/"+'0',
	                dataType: "json"
	           },
	        },
		pageSize: 20,
	});
	$("#gridTransactionChildList").kendoGrid({
		dataSource: sourceTransactionChild,
		pageable: false,
		selectable: true,
		sortable: true,
		height: 350,
		change: function(e) {
			  grid = e.sender;
			  var selectedValue = grid.dataItem(this.select());
			  btnSet(selectedValue.id, selectedValue.transaction_parent_id, selectedValue.penalty);
			  $("#txtRemark").val(selectedValue.remark);
		}, 
		filter: true,
	    	columns: [
	    	    { field:"index", title: "ລດ", width: '6%', hidden : false},
	    	    { field:"id", title: "ລະຫັດ", width: '5%', hidden : true},
	    	    { field:"title", title: "ສິນຄ້າ", width: '20%', encoded:false },
	    	    { field:"date", title: "ວັນທີ", width: '17%', encoded:false },
	    	    { field:"issue_slip_id", title: "ເລກທີບິນ", width: '15%', encoded:false },
	    	    { field:"quality", title: "ຈຳນວນ", width: '15%', encoded:false },
	    	    { field:"price", title: "ລາຄາ", width: '20%', encoded:false },
	    	    { field:"total", title: "ລວມເງິນ", width: '18%', encoded:false },

	        ],
	});
});
</script>

@include('layout.footer')