<?php 

	use Illuminate\Support\Facades\Input;
	/**
	 * Transaction Payment Controller
	 * ----------------------
	 * @author Somwang
	 */

class TransactionPaymentController extends BaseController {
	
	/*
	 * INdex
	 * -----
	 */
	public function index() {
		
		$payment = TransactionPayment::find(Route::input('invoice_id'));
        $invoice = TransactionInvoice::find(Route::input('invoice_id'));
        
		return View::make('payment/index')->with('payment', $payment)->with('invoice',$invoice);
	}
	
	/*
	 * Payment Json
	 * ------------
	 */
	public function paymentJson() {
		
		$invoice_id = Route::input('invoice_id');
		
		$data = TransactionPayment::where('transaction_invoice_id',$invoice_id)->orderBy('payment_date','desc')->get()->toArray();
		
		foreach( $data as $key => $value ) {
			$user =  User::find($value['user_id']);
			$data[$key]['user'] = $user->firstname.' '.$user->lastname;
			$data[$key]['amount'] = number_format($value['amount'],2).' THB';
			$data[$key]['payment_date'] = Tool::toDate($value['payment_date']);
			$data[$key]['updated_at'] = Tool::toDateTime($value['updated_at']);
			//​​$data[$key]['amountcd'] = '<b>'.number_format($value['amount']).'</b> THB';
		}
		return Response::json($data)->setCallback(Input::get('callback'));
	}
	
	/*
	 * Make Payment
	 * ------------
	 */
	public function receive() {
		
		$invoice_id = Route::input('invoice_id');
		
		$TransactionInvoice = TransactionInvoice::find($invoice_id);
		
		$Customer = Customer::find($TransactionInvoice->customer_id);
		
		return View::make('payment/create')->with('invoice', $TransactionInvoice)->with('customer',$Customer);
	}
	
	/*
	 * Make Payment Submit
	 * -------------------
	 */
	public function receiveSubmit() {
		
		$invoice_id = Input::get('invoice_id');
		
		$rules = array(

			'invoice_clear_date'            => 'required',
			'amountPaid'            => 'required', 
		);
		
		$messages = array(

			'invoice_clear_date.required' => 'ກະລຸນາເລືອກ ວັນທີຊຳລະເງິນ',
			'amountPaid.required' => 'ກະລຸນາ ໃສ່ຈຳນວນເງິນ'
		);
		
		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {

			$messages = $validator->messages();

			return Redirect::to('payment/receive/'.$invoice_id)->withErrors($validator);
		
		} else {
		
			$invoice = TransactionInvoice::find($invoice_id);
			
			$payment = new TransactionPayment();

			$payment->amount = Input::get('amountPaid');
			$payment->transaction_parent_str = $invoice->transaction_parent_str;
			$payment->user_id = Auth::id();
			$payment->transaction_invoice_id = $invoice_id;
			
			$total_amount = round($invoice->amount);
			
			$payment_amount = Input::get('amountPaid');

			# If Payment Amount is < Total Amount
			if( $payment_amount < $total_amount  ) {

				
				$remain_amount = $total_amount - $payment_amount;
				
				# Create new invoice
				$new_invoice = new TransactionInvoice();
				$new_invoice->customer_id = $invoice->customer_id;
				$new_invoice->transaction_parent_str = $invoice->transaction_parent_str;
				$new_invoice->amount = $remain_amount;
				$new_invoice->status = 0;
				//$new_invoice->invoice_issue_user_id = Auth::id();
				$new_invoice->save();
				
				$update_invoice = TransactionInvoice::find($new_invoice->id);
				$update_invoice->invoice_number = Customer::find($invoice->customer_id)->transaction_prefix.$new_invoice->id;
				$update_invoice->save();
			}
			
			$invoice->status = 2;
			$invoice->invoice_clear_date = Tool::toMySqlDate(Input::get('invoice_clear_date'));
			$invoice->invoice_clear_user_id = Auth::id();
			$invoice->save();
			$payment->save();

			return Redirect::to('invoice/'.$invoice->transaction_parent_str)->with('message','ລາຍການຊຳລະໄດ້ຖືກບັນທຶກແລ້ວ');
		
		}
	}
	
	/*
	 * Payment remove
	 * ---------------
	 */
	public function payment_remove() {
	    
	    return View::make('payment/remove');
	}
	
	/*
	 * Payment remove submit
	 * ----------------------
	 */
	public function payment_remove_submit() {
	    
	    $payment_id = Input::get('payment_id');
	    
	    $payment = TransactionPayment::find($payment_id);
	    
	    $invoice = TransactionInvoice::find($payment->transaction_invoice_id);
	    
	    $countPayment = TransactionPayment::where('transaction_invoice_id',$payment->transaction_invoice_id)->count();

	    if( $countPayment == 1 ) {
	        $status = 1;
	    } else {
	        $status = 2;
	    }
	    $invoice->status = $status;
	    $invoice->save();
	    $payment->delete();

	    return Redirect::to('transaction/payment/'.$payment->transaction_invoice_id)->with('message','ລາຍການ ຊຳລະເງິນ ໄດ້ຖືກລົບລ້າງແລ້ວ');
	}
	
}