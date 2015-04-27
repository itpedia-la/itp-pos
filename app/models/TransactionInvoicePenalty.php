<?php

/**
 * Transaction Payment Model
 * -------------------
 * @author Somwang 
 *
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TransactionInvoicePenalty extends Eloquent {

	use SoftDeletingTrait;

	protected $table = 'transaction_invoice_penalty';

	/**
	 * Get Invoice Penalty by transaction_parent_str
	 * ---------------------------------------------
	 */
	public static function get_invoice_penalty( $transaction_parent_str ) {
	
		$invoices = TransactionInvoicePenalty::where('transaction_parent_str',$transaction_parent_str)->get();
	
		$i = 0;
	
		if( $invoices->count() > 0 ) {
			foreach( $invoices->toArray() as $key => $value ) {
					
				$i = $i + 1;
				$data[] = array(
						'index' => $i,
						'penalty' => 1,
						'id' => $value['id'],
						'title' => 'ຄ່າປັບໄຫມຄ້າງຊຳລະ',
						'date' => Tool::toDate($value['created_at']),
						'issue_slip_id' => TransactionInvoice::find($value['transaction_invoice_id'])->invoice_number,
						'quality' => 1,
						'price' => number_format($value['amount_total'],2). ' THB',
						'total' => number_format($value['amount_penalty'],2). ' THB',
			
				);
			}
		} else {
			$data = '';
		}
		
		return $data;
	}
	
	/**
	 * Get Invoice Penalty Print by transaction_parent_str
	 * ---------------------------------------------
	 */
	public static function get_invoice_penalty_print( $transaction_parent_str ) {
	
		$invoices = TransactionInvoicePenalty::where('transaction_parent_str',$transaction_parent_str)->get();
	
		$i = 0;
	
		if( $invoices->count() > 0 ) {
			foreach( $invoices->toArray() as $key => $value ) {
					
				$invoice = TransactionInvoice::find($value['transaction_invoice_id']);
				
				$i = $i + 1;
				$data[] = array(
						'index' => $i,
						'id' => $value['id'],
						'invoice_number' => $invoice->invoice_number,
						'invoice_issue_date' => Tool::toDate($invoice->invoice_issue_date),
						'invoice_due_date' => Tool::toDate($invoice->invoice_due_date),
						'issue_slip_id' => TransactionInvoice::find($value['transaction_invoice_id'])->invoice_number,
						'quality' => 1,
						'percentage_of_penalty' => number_format($value['percentage_of_penalty'],2),
						'amount_total' => number_format($value['amount_total'],2). ' THB',
						'amount_penalty' => number_format($value['amount_penalty'],2). ' THB',
							
				);
			}
		} else {
			$data = '';
		}
	
		return $data;
	}
}
