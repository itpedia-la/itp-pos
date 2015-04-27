<?php 

	use Illuminate\Support\Facades\Input;
	/**
	 * Transaction Controller
	 * ----------------------
	 * @author Somwang
	 */

class TransactionParentController extends BaseController {
	
	/**
	 * Transaction: Quatation Index
	 * ----------------------------
	 * @author Somwang
	 */
	public function index() {
		
		$data = TransactionParent::getData(date('01-M-Y'),date('t-M-Y'));

		return View::make('transaction/index')->with('data',$data);
		
	}
	
	/**
	 * Transaction: Create new
	 * -----------------------
	 * @author Somwang
	 */
	public function add() {
		
		return View::make('transaction/add');
	}
	
	/**
	 * Get Transaction Parent in Json format
	 * -------------------------------------
	 * @author Somwang
	 */
	public function transactionParentJson() {

		$start_date = date('Y-m-01', strtotime(Route::input('month')));
		 
		$end_date = date('Y-m-t', strtotime(Route::input('month')));

		$data = TransactionParent::getData($start_date, $end_date);
		
		return Response::json($data)->setCallback(Input::get('callback'));
	}


	/**
	 * Transaction: Add submit
	 * -----------------------
	 * @author Somwang
	 */
	public function addSubmit() {

		$rules = array(
				'customer_id'            => 'required',     // required and must be unique in the ducks table
		);
		
		$messages = array(
				'customer_id.required' => 'ກະລຸນາເລືອກລາຍການລູກຄ້າ'
		);
		
		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {
		
			// get the error messages from the validator
			$messages = $validator->messages();
		
			// redirect our user back to the form with the errors from the validator
			return Redirect::to('transaction/add/'.Input::get('transaction_status'))->withErrors($validator);
		
		} else {

			$TransactionParent = new TransactionParent();
			//$TransactionParent->customer_id = Input::get('customer_id');
			
			# Find Customer Prefix
			$CustomerPrefix = Customer::find(Input::get('customer_id'));
			$CustomerPrefix = $CustomerPrefix->transaction_prefix;
			
			$transaction_date = Tool::toMySqlDate(Input::get('transaction_date'));
			
			$dept_duration = Input::get('dept_duration') + 1;
			
			$next_penalty_date = strtotime("+".$dept_duration." days", strtotime($transaction_date));
			$next_penalty_date = date("Y-m-d",$next_penalty_date);
		
			# Get latest Exchange Rate
			$ExchangeRate = DB::table('exchange_rate')->orderBy('id', 'desc')->first();
			$TransactionParent->transaction_date = $transaction_date;
			$TransactionParent->created_by = Auth::id();
			$TransactionParent->company_name = Input::get('company_name');
			$TransactionParent->transaction_status = Input::get('transaction_status');
			$TransactionParent->contact_name = Input::get('contact_name');
			$TransactionParent->contact_telephone = Input::get('contact_telephone');
			$TransactionParent->penalty_fee_m3 = Input::get('penalty_fee_m3');
			$TransactionParent->overpaid_charge_percentage = Input::get('overpaid_charge_percentage');
			$TransactionParent->dept_duration = Input::get('dept_duration');
			$TransactionParent->next_penalty_date = $next_penalty_date;
			$TransactionParent->customer_id = Input::get('customer_id');
			$TransactionParent->quotation_expired_at = Tool::toMySqlDate(Input::get('quotation_expired_at'));
			$TransactionParent->send_location = Input::get('send_location');
			$TransactionParent->exchange_rate_id = $ExchangeRate->id;
			$TransactionParent->send_location = Input::get('send_location');
			$TransactionParent->save();
			
			# Update Transaction Number
		    $TransactionParentUpdate = TransactionParent::find($TransactionParent->id);
			$TransactionParentUpdate->transaction_number = $CustomerPrefix.''.$TransactionParent->id;
			$TransactionParentUpdate->save();

			# Check transaction Invoice and update if it existed
			$TransactionInvoice = TransactionInvoice::where('customer_id',Input::get('customer_id'))->where('invoice_date','<=',date('Y-m-t',strtotime($transaction_date)))->where('invoice_date','>=',date('Y-m-01',strtotime($transaction_date)));

			if( $TransactionInvoice->count() > 0) {
				
				$transaction_parent_str = $TransactionInvoice->get()->toArray()[0]['transaction_parent_str'];
				
				# Update transaction_parent_str
				TransactionParent::transaction_parent_str_update('update', $transaction_parent_str, $TransactionParent->id, Input::get('customer_id') );

			} else {
				
				# Create New Invoice
				$TransactionInvoice = new TransactionInvoice();
				$TransactionInvoice->customer_id = Input::get('customer_id');
				$TransactionInvoice->invoice_date = $transaction_date;
				$TransactionInvoice->transaction_parent_str = $TransactionParent->id;
				$TransactionInvoice->amount = 0;
				$TransactionInvoice->status = 0;
				$TransactionInvoice->invoice_create_user_id = Auth::id();
				$TransactionInvoice->save();
				
				# Update Invoice NUmber
				$TransactionInvoiceUpdate = TransactionInvoice::find($TransactionInvoice->id);
				$TransactionInvoiceUpdate->invoice_number = $CustomerPrefix.$TransactionInvoice->id;
				$TransactionInvoiceUpdate->save();
				
			}

			return Redirect::to('transaction')->with('message','ລາຍການໄດ້ຖືກບັນທຶກແລ້ວ');

		}
		
	}
	
	/**
	 * Change Quotation into Invoice
	 * -----------------------------
	 */
	public function change_status_to_invoice() {
		
		$tran_parent_id = Route::input('tran_parent_id');
		$tran_parent = TransactionParent::find($tran_parent_id);
		$dept_duration = $tran_parent->dept_duration;
		
		return View::make('transaction/change_status')->with('dept_duration',$dept_duration);
		
	}
	
	/**
	 * Change Quotation into Invoice Submit
	 * -----------------------------
	 */
	public function change_status_to_invoice_submit() {
	
		$Transaction = TransactionParent::find(Input::get('tran_parent_id'));
		$Transaction->transaction_status = 1;
		$Transaction->due_paid_at = Tool::toMySqlDate(Input::get('due_paid_at'));
		$Transaction->save();
	
		return Redirect::to('transaction')->with('message','ລາຍການໄດ້ຖືກປ່ຽນແລ້ວ');
	
	}
	
	/**
	 * Transaction Cancel
	 * ------------------
	 */
	public function cancel() {

		return View::make('transaction/remove');
	
	}
	
	/**
	 * Cancel Submit
	 * -------------
	 */
	public function cancelSubmit() {

		$tran_parent_id = Input::get('tran_parent_id');
		
		$customer_id = TransactionParent::find($tran_parent_id)->customer_id;
		
		TransactionChild::where('transaction_parent_id','=',$tran_parent_id)->delete();

		# Remove transaction_parent_id from transaction_parent_str
		TransactionParent::transaction_parent_str_update('remove', null, $tran_parent_id, $customer_id );
		
		TransactionParent::find($tran_parent_id)->delete();

		return Redirect::to('transaction')->with('message','ລາຍການໄດ້ຖືກຍົກເລີກແລ້ວ');
	
	}
	
	/**
	 * Transaction Payment
	 * ------------------
	 */
	public function payment() {
	
		$tran_parent_id = Route::input('tran_parent_id');
		
		$tranParent = TransactionParent::find($tran_parent_id);

		# Find Payment
		$PaymentTotal = TransactionPayment::where('status','=',0)->where('transaction_parent_id','=',$tran_parent_id)->sum('amount');
		
		$grand_total = $tranParent->grand_total - $PaymentTotal;
		
		$paymentPending = TransactionPayment::where('status','=',0)->where('transaction_parent_id','=',$tran_parent_id)->count();

		return View::make('transaction/payment')->with('tranParent',$tranParent)->with('grand_total',$grand_total)->with('paymentPending',$paymentPending);
	
	}
	
	/**
	 * Payment Submit
	 * -------------
	 */
	public function paymentSubmit() {
		
		$tran_parent_id = Input::get('tran_parent_id');
		
		$rules = array(
				'payment_type'            => 'required',     // required and must be unique in the ducks table
		);
		
		$messages = array(
				'payment_type.required' => 'ກະລຸນາເລືອກ ປະເພດການຊຳລະເງິນ'
		);
		
		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {
		
			// get the error messages from the validator
			$messages = $validator->messages();
		
			// redirect our user back to the form with the errors from the validator
			return Redirect::to('transaction/payment/'.$tran_parent_id)->withErrors($validator);
		
		} else {
		
			# Find Transaction
			$Transaction = TransactionParent::find($tran_parent_id)->toArray();

			# Find current payment
			$Payment = TransactionPayment::where('transaction_parent_id','=',$tran_parent_id)->get()->count();
			$Payment = $Payment+1;

			$subNumber = $Transaction['transaction_number'].'_'.$Payment;
		
			$TranPayment = new TransactionPayment();

			$TranPayment->payment_date = Tool::toMySqlDate(Input::get('payment_date'));
			$TranPayment->payment_due_date  = Tool::toMySqlDate(Input::get('payment_due_date'));
			$TranPayment->transaction_parent_id = $tran_parent_id;
			$TranPayment->transaction_number_sub = $subNumber;
			$TranPayment->payment_type = Input::get('payment_type');
			$TranPayment->amount = Input::get('amount');
			$TranPayment->amount_usd = Input::get('amount_usd');
			$TranPayment->amount_lak = Input::get('amount_lak');
			$TranPayment->exchange_rate_id = Input::get('exchange_rate_id');
			$TranPayment->status = 0;
			$TranPayment->user_id = 1;
			$TranPayment->save();
	
			if( $Transaction['grand_total'] > Input::get('amount') ) {
				$TranParent = TransactionParent::find($tran_parent_id);
				$TranParent->transaction_status = 2;
				$TranParent->save();
			}
			return Redirect::to('transaction')->with('message_child','ລາຍການຊຳລະໄດ້ຖືກບັນທຶກແລ້ວ');
		
		}
	}
	
	/*
	 * Quotation Print
	 * ---------------
	 */
	public function print_quotation() {
		
		$tran_parent_id = Route::input('tran_parent_id');
		
		$tranParent = TransactionParent::find($tran_parent_id);
		
		$company = CompanyProfile::find(1);
		
		$customer = Customer::find($tranParent->customer_id);
		
		$tranChild = TransactionChild::getDataByParentId($tran_parent_id);
		
		$sum_m3 = TransactionChild::where('transaction_parent_id','=',$tran_parent_id)->sum('quality');
		
		return View::make('transaction/print_quotation')->with('company',$company)->with('customer',$customer)->with('transaction_parent', $tranParent)->with('tranChild',$tranChild)->with('sumM3',$sum_m3);
	}
	
	
	
	/*
	 * Create Customer Invoice
	 * -----------------------
	 */
	public function create_invoice() {
		
		$tranparent_array = explode('-',Route::input('transaction_parent_str'));
		
		if( date('m',strtotime(Route::input('month'))) == date('m') )  {
			
			$date =  array(
					'date_start' => date('01-M-Y',strtotime(Route::input('month'))), 
					'date_end' => date('t-M-Y')
			);
			
		} else {
			
			$date =  array(
					'date_start' => date('01-M-Y',strtotime(Route::input('month'))), 
					'date_end' => date('t-M-Y',strtotime(Route::input('month'))) 
			);

		}

		$sum = TransactionParent::whereIn('id',$tranparent_array)->where('customer_id',Route::input('customer_id'))->sum('grand_total');
		
		return View::make('transaction/create_invoice')->with('sum',$sum)->with('date',$date);;
	}
	
	public function create_invoice_submit() {
		
		$invoice = new TransactionInvoice();
		$invoice->transaction_parent_str = Input::get('transaction_parent_str');
		$invoice->amount = Input::get('amount');
		$invoice->payment_date = Tool::toMySqlDate(Input::get('payment_date'));
		$invoice->payment_due_date = Tool::toMySqlDate(Input::get('payment_due_date'));
		$invoice->status = 1;
		$invoice->number_of_print = 0;
		$invoice->date_start = Tool::toMySqlDate(Input::get('date_start'));
		$invoice->date_end = Tool::toMySqlDate(Input::get('date_end'));
		$invoice->customer_id = Input::get('customer_id');
		$invoice->user_id = Auth::id();
		$invoice->save();
		
		$Customer = Customer::find(Input::get('customer_id'));
		
		$invoiceUpdate = TransactionInvoice::find($invoice->id);
		$invoiceUpdate->invoice_number = $Customer->transaction_prefix.$invoice->id;
		$invoiceUpdate->save();
		
		# Set transaction_invoice id to transaction parent
		$transaction_parent_ids = explode('-',Input::get('transaction_parent_str'));

		foreach( $transaction_parent_ids as $value ) {
		    $TransactionParent = TransactionParent::find($value);
		    if( $TransactionParent->transaction_invoice_id == '') {
		        $TransactionParent->transaction_invoice_id = $invoice->id;
		        $TransactionParent->save();
		    }
		}
		
		return Redirect::to('transaction/')->with('message','ໃບຮຽກເກັບເງິນໄດ້ຖືກບັນທຶກແລ້ວ');
	}
	
}


