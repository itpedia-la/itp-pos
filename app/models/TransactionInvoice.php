<?php

/**
 * Transaction Payment Model
 * -------------------
 * @author Somwang 
 *
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TransactionInvoice extends Eloquent {

	use SoftDeletingTrait;

	protected $table = 'transaction_invoice';

	/*
	 * Get data
	 * --------
	 */
	public static function getData($transaction_parent_str) {

		$data = TransactionInvoice::where('transaction_parent_str','=',$transaction_parent_str);
		
		$i = 0;
		
		if( $data->count() > 0 ) {
			
			$data = $data->get()->toArray();
			
			foreach($data as $key => $row ) {
				
				$i = $i + 1;
				
				# Find Payment 
				$payment = TransactionPayment::where('transaction_invoice_id','=',$row['id'])->first();

				# Find Penalty
				$transactionInvoicePenalty = TransactionInvoicePenalty::where('transaction_invoice_id',$row['id'])->get();
				
				if( $transactionInvoicePenalty->count() > 0 ) {
					$transactionInvoicePenalty = $transactionInvoicePenalty->first();
					$penalty = $row['status'] == 3 ? ' (+'.number_format($transactionInvoicePenalty->amount_penalty,2).')' : '';
				} else {
					$penalty = '';
				}
				
				
				$penalty_sum = TransactionInvoicePenalty::where('transaction_parent_str',$transaction_parent_str)->sum('amount_penalty');
				$penalty_sum = $penalty_sum > 0 ? $penalty_sum : 0;
				
				//if( $transactionInvoicePenalty && $transactionInvoicePenalty->transaction_invoice_id == $row['id'] ) {
					
					$amount = $row['amount'];
					
				//} else {
					
					//$amount = $row['amount'] + $penalty_sum;
				//}

				# Find Customer
				$Customer = Customer::find($row['customer_id']);
				$data[$key]['index'] = $i;
				$data[$key]['status_html'] = TransactionInvoice::status($row['status']);
				$data[$key]['status'] = $row['status'];
				$data[$key]['customer'] = $Customer->company_name;
				$data[$key]['amount_html'] = number_format($amount,2). ' '.$penalty; 
				$data[$key]['invoice_date'] = Tool::toDate($row['invoice_date']);
				$data[$key]['amount'] = $amount;
				$data[$key]['paid_amount'] = $payment['amount'] > 0 ? number_format($payment['amount'],2).' ' : '0';
				$data[$key]['invoice_issue_date'] = $row['invoice_issue_date'] ? Tool::toDate($row['invoice_issue_date']) : '';
				$data[$key]['invoice_issue_user'] = $row['invoice_issue_user_id'] > 0 ? User::find($row['invoice_issue_user_id'])->firstname : '';
				$data[$key]['invoice_due_date'] = $row['invoice_due_date'] ? Tool::toDate($row['invoice_due_date']) : '';
				$data[$key]['invoice_clear_date'] = $row['invoice_clear_date'] ? Tool::toDate($row['invoice_clear_date']) : '';
				$data[$key]['invoice_clear_user'] = $row['invoice_clear_user_id'] > 0 ? User::find($row['invoice_clear_user_id'])->firstname : '';
				$data[$key]['invoice_penalty_date'] = $row['invoice_penalty_date'] ? Tool::toDate($row['invoice_penalty_date']) : '';
			}
		}

		return $data;
	}
	
	/*
	 * Status
	 * ------
	 */
	public static function status($status) {
		
		switch( $status ) {
			
			case 1:
				$data = '<span class="tag orange">ລໍຖ້າຊຳລະ</span>';
				break;
			case 2:
				$data = '<span class="tag green">ຊຳລະເງິນແລ້ວ</span>';
				break;
			case 3:
				$data = '<span class="tag red">ກາຍກຳໜົດຊຳລະເງິນ</span>';
				break;
			default: 
				$data = '<span class="tag light-gray-bordered">ຖ້າອອກໃບຮຽກເກັບ</span>';
				break;
		}
		
		return $data;
	}
	
	/*
	 * UPdate Invoice Amount by Transaction Parent Id
	 * 
	 */
	public static function amountUpdate($transaction_parent_id) {
	    
	    # Find transaction invoice
	    $invoice = TransactionInvoice::where('transaction_parent_str','LIKE','%'.$transaction_parent_id.'%')->orderBy('id','desc')->get()->toArray();
	    
	    $invoice_id = $invoice[0]['id'];
	    
	    # Update Invoice Amount based on transaction parent id
	    $transaction_parent_ids = explode('-',$invoice[0]['transaction_parent_str']);
	    
	    $total = 0;
	    foreach( $transaction_parent_ids as $value ) {

	        $total = $total + TransactionParent::find($value)->grand_total;
	        
	    }

	    # Find Payment
	    $total_paid = TransactionPayment::where('transaction_parent_str',$invoice[0]['transaction_parent_str'])->sum('amount');

	    # Find Lastet Penalty
	    $penalty = TransactionInvoicePenalty::where('transaction_parent_str',$invoice[0]['transaction_parent_str'])->orderBy('id','desc')->get();
	    
	    if( $penalty->count() > 0 ) {
	    
	    	$penalty = $penalty->first()->toArray();
   	 
	    	$total_amount = ($total - $total_paid) + $penalty['amount_penalty'];
	    	
	    } else {
	    	 
	    	$total_amount = $total - $total_paid ;
	    	 
	    }
	    
	    $TransactionInvoice = TransactionInvoice::find($invoice_id);
	    // $TransactionInvoice->amount = ( $total - $total_paid ) + $penalty['amount_penalty'];
	    $TransactionInvoice->amount =  $total_amount;

	    $TransactionInvoice->save();

	}
	
	/*
	 * Update Invoice Amount by Transaction Invoice Id
	 * 
	 */
	public static function amountUpdateById($transaction_invoice_id) {
	
		$invoice = TransactionInvoice::find($transaction_invoice_id);

		$transaction_parent_ids = explode('-',$invoice->transaction_parent_str);

		$total = 0;

		foreach( $transaction_parent_ids as $value ) {
			$total = $total + TransactionParent::find($value)->grand_total;
		}

		$invoice->amount = $total;
		$invoice->save();
		
	}	
	
	/*
	 * Invoice Title
	 * -------------
	 */
	public static function title($invoice_id) {
		
		$invoice = TransactionInvoice::find($invoice_id);
		$status = $invoice->status;
		
		switch($status) {
			case 0:
			case 1:
			case 3:
				$title = array('la'=>'ໃບຮຽກເກັບເງິນ','en'=>'INVOICE','type'=>0);
				break;
			default:
				$title = array('la'=>'ໃບຮັບເງິນ','en'=>'RECEIPT', 'type'=>1);

				break;
		}
		
		return $title;
	}
}
