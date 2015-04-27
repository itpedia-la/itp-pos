<?php

/**
 * Transaction Payment Model
 * -------------------
 * @author Somwang 
 *
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TransactionPayment extends Eloquent {

	use SoftDeletingTrait;

	protected $table = 'transaction_payment';

	/*
	 * Get Remain amount by invoice_id
	 * -------------------------------
	 */
	public static function getRemain($invoice_id) {
		
		$invoice = TransactionInvoice::find($invoice_id);
		
		$paid = TransactionPayment::where('transaction_invoice_id',$invoice_id)->sum('amount');
		
		$remain = $invoice->amount - $paid;
		
		return $remain;
	}
	
	/*
	 * Get Remain amount by invoice_id
	 * -------------------------------
	 */
	public static function getPaid($invoice_id) {

		$paid = TransactionPayment::where('transaction_invoice_id',$invoice_id)->sum('amount');
	
		return $paid;
	}
}
