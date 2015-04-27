<?php

class InvoiceController extends BaseController {

	public function index()
	{

		return View::make('invoice/index');
	}
	
	public function getJsonList() {
		
		$transaction_parent_str = Route::input('transaction_parent_str');
		
		$data = TransactionInvoice::getData($transaction_parent_str);
		
		return Response::json($data)->setCallback(Input::get('callback'));
	}
	
	/*
	 * Invoice Out
	 * ------------
	 */
	public function invoiceOut() {
		return View::make('invoice/out');
	}
	
	/*
	 * Invoice Out Submit
	 * ------------------
	 */
	public function invoiceOutSubmit() {
		
		$invoice_id = Input::get('invoice_id');
		
		$invoice_issue_date = Tool::toMySqlDate(Input::get('invoice_issue_date'));
		
		# Find Invoice
		$Invoice = TransactionInvoice::find($invoice_id);
		
		# Find Customer
		$Customer = Customer::find($Invoice->customer_id);
		
		$dept_duration = $Customer->dept_duration == 0 ? 30 : $Customer->dept_duration;
		
		$invoice_due_date = Tool::getNextDate($invoice_issue_date, $dept_duration);
		
		$invoice_penalty_date = Tool::getNextDate($invoice_issue_date, $dept_duration+1);
		
		$Invoice->status = 1;
		$Invoice->invoice_issue_date = $invoice_issue_date;
		$Invoice->invoice_due_date = $invoice_due_date;
		$Invoice->invoice_penalty_date = $invoice_penalty_date;
		$Invoice->invoice_issue_user_id = Auth::id();
		$Invoice->save();

		return Redirect::to('invoice/'.$Invoice->transaction_parent_str)->with('message','ໃບຮຽກເກັບເງິນອອກແລ້ວ');
		
	}
	
	/*
	 * Invoice Edit
	 * ------------
	 */
	public function invoiceEdit() {
		return View::make('invoice/edit');
	}
	
	/*
	 * Invoice Edit Submit
	 * -------------------
	 */
	public function invoiceEditSubmit() {
	
		$invoice_id = Input::get('invoice_id');
		
		$invoice_issue_date = Tool::toMySqlDate(Input::get('invoice_issue_date'));
		
		# Find Invoice
		$Invoice = TransactionInvoice::find($invoice_id);
		
		# Find Customer
		$Customer = Customer::find($Invoice->customer_id);
		
		$invoice_due_date = Tool::getNextDate($invoice_issue_date, $Customer->dept_duration);
		
		$invoice_penalty_date = Tool::getNextDate($invoice_issue_date, $Customer->dept_duration+1);
		
		//$Invoice->status = 1;
		$Invoice->invoice_issue_date = $invoice_issue_date;
		$Invoice->invoice_due_date = $invoice_due_date;
		$Invoice->invoice_penalty_date = $invoice_penalty_date;
		//$Invoice->invoice_issue_user_id = Auth::id();
		$Invoice->save();
		
		return Redirect::to('invoice/'.$Invoice->transaction_parent_str)->with('message','ໃບຮຽກເກັບເງິນໄດ້ຖືກບັນທຶກແລ້ວ');
	}
	
	/*
	 * Customer Invoice Print
	 * ----------------------
	 */
	public function invoice_print() {
	
		$company = CompanyProfile::find(1);
	
		$customer = Customer::find(Route::input('customer_id'));
		$Invoice = TransactionInvoice::find(Route::input('invoice_id'));
		$printNo = $Invoice->number_of_print + 1;
		$Invoice->number_of_print = $printNo;
		$Invoice->save();
	
		# Find Start Date
		$parentArray = explode('-',$Invoice->transaction_parent_str);
		$date_start = TransactionParent::find( min($parentArray) )->transaction_date;
	
		# Find End Date 
		$date_end = TransactionParent::find( max($parentArray) )->transaction_date;
		
		$data = TransactionParent::getCustomInvoice(Route::input('customer_id'), $date_start, $date_end);
	
		# Find INvoice nUmber
		#$invoice_number = $customer->transaction_prefix.''.Route::input('invoice_id').'-'.$printNo;
		$invoice_number = $customer->transaction_prefix.''.Route::input('invoice_id');
		
		# Find Penalty
		$penalty = TransactionInvoicePenalty::get_invoice_penalty_print($Invoice->transaction_parent_str);

		return View::make('invoice/print')->with('company',$company)->with('customer',$customer)->with('data',$data)->with('invoice_number',$invoice_number)->with('date_from',$Invoice->date_start)->with('date_end', $Invoice->date_end)->with('invoice',$Invoice)->with('penalty',@$penalty);
	}
	


}
