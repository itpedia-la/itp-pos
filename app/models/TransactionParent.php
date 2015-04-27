<?php

/**
 * Transaction Parent Model
 * -------------------
 * @author Somwang 
 *
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TransactionParent extends Eloquent {

	use SoftDeletingTrait;
	
	protected $table = 'transaction_parent';

	/**
	 * Get Transaction Parent with rebuild array
	 * -----------------------------------------
	 * @return unknown
	 */
	public static function getData($start_date, $end_date, $report = false) {

		
		$TransactionParent = TransactionParent::where('transaction_date','>=',$start_date)->where('transaction_date','<=',$end_date)->groupBy('customer_id')->orderBy('transaction_date','asc')->get()->toArray();

		$data = TransactionParent::rebuild($start_date, $end_date, $TransactionParent, $report);

		/*echo '<pre>';
		 print_r($data);
		 echo '</pre>';
		 exit();*/
		return $data;
	}
	
	/**
	 * Get Data Custom Invoice
	 * -----------------------
	 */
	public static function getCustomInvoice($customer_id, $start_date, $end_date) {
		
		$TransactionParent = TransactionParent::where('transaction_date','>=',$start_date)->where('transaction_date','<=',$end_date)->where('customer_id', $customer_id)->groupBy('customer_id')->orderBy('transaction_date','asc')->get()->toArray();
		
		$data = TransactionParent::rebuild($start_date, $end_date, $TransactionParent);
		
		/*echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit();*/
		return $data;
		
	}
	
	/**
	 * Rebuild transaction
	 * -------------------
	 * @param $TransactionParent array
	 */
	public static function rebuild($start_date, $end_date, $TransactionParent, $report = false) {
		
		$data = array();
		$i = -1;
		
		$grand_sum_m3 = 0;
		$grand_sum_total = 0;
		$grand_sum_paid = 0;
		$grand_sum_remain = 0;
		
		foreach($TransactionParent as $trankey => $tranVal) {
		
			$start_date = Tool::toMySqlDate($start_date);
			$end_date = Tool::toMySqlDate($end_date);
			
			$i = $i + 1;
			# Find Tran Parent;
			$parent = TransactionParent::where('transaction_date','>=',$start_date)->where('transaction_date','<=',$end_date)->where('customer_id',$tranVal['customer_id'])->orderBy('transaction_date','asc')->get()->toArray();
		
			/*echo '<br/>';
			echo $end_date.'<br/>';
			echo "<pre>";
			print_r($parent);
			echo "</pre>";*/
			
			# Collecting TrasactionParentId
			$transaction_parents_str = '';
			foreach( $parent as $x => $xVal) {
				$parentArray[] = array($xVal['id']);
				$transaction_parents_str.= $xVal['id'].'-';
			}
			$transaction_parents_str = rtrim($transaction_parents_str,'-');

			if( count($parent) > 0 ) {
		
				# Find Customer
				$Customer = Customer::find($tranVal['customer_id']);
				$sum_m3_all = TransactionChild::whereIn('transaction_parent_id', $parentArray)->where('product_id','>',0)->sum('quality');
				$sum_grand_total_all = TransactionParent::whereIn('id', $parentArray)->sum('grand_total');
				
				# Find for Penalty Invoice
				$invoice_penalty = TransactionInvoicePenalty::where('transaction_parent_str',$transaction_parents_str);
				
				$amount_penalty = $invoice_penalty->sum('amount_penalty');
				$amount_penalty = $invoice_penalty->get()->count() > 0 ? $invoice_penalty->sum('amount_penalty') : 0;
				
				$sum_grand_total_all = $sum_grand_total_all + $amount_penalty;

				# Find Invoice
				$InvoiceDetail = TransactionInvoice::where('transaction_parent_str',$transaction_parents_str)->orderBy('id','desc')->get()->first();

				if( count($InvoiceDetail) > 0) {
				
					$Invoice = 1;
					$InvoiceDetail = $InvoiceDetail->toArray();
				} else {
					$Invoice = 0;
					$InvoiceDetail = null;
				}
				
				$invoice_paid = TransactionPayment::where('transaction_parent_str',$transaction_parents_str)->sum('amount');
				
				$invoice_remain = $sum_grand_total_all - $invoice_paid;

				$penalty = $invoice_penalty->get()->count() > 0 ? $penalty = '<span class="sprite appointment-reminders-16.png">&nbsp;</span>' : '';
				
				$data[] = array(
						'index' => $i+1,
						'header' => 1,
						'penalty' => @$penalty,
						'invoice' => $Invoice,
						'invoice_id' => $InvoiceDetail['id'],
						'invoice_number' 	=> $Invoice > 0 ? '<span class="tag light-gray-bordered">'.$InvoiceDetail['invoice_number'].'</span>' : '',
						'invoice_amount' 	=> $Invoice > 0 ? '<b>'.number_format($InvoiceDetail['amount'],2).'</b> THB' : '',
						'invoice_paid' 		=> $Invoice > 0 ? '<b>('.number_format($invoice_paid,2).'</b>) THB' : '',
						'invoice_remain' 	=> $Invoice > 0 ? '<b>'.number_format($invoice_remain,2).'</b> THB' : '',
						'invoice_status' => $Invoice > 0 ? $InvoiceDetail['status'] : '',
						'invoice_status_html' 	=> $Invoice > 0 ? TransactionInvoice::status($InvoiceDetail['status']) : '',
						'customer' => $Customer->company_name,
						'customer_id' => $Customer->id,
						'transaction_parent_str' => $transaction_parents_str,
						'sum_m3' => '<b>'.$sum_m3_all.'</b> m<sup>3</sup>',
						'sum_grand_total_all' => '<b>'.number_format($sum_grand_total_all,2).'</b> THB',
						'transaction_childs' => @$invoice_penalty_array,

				);
				unset($parentArray);

				# Grand Sum Calc
				$grand_sum_m3 = $grand_sum_m3 + $sum_m3_all;
				$grand_sum_total = $grand_sum_total + $InvoiceDetail['amount'];
				$grand_sum_paid = $invoice_paid;
				$grand_sum_remain = $grand_sum_remain+ $invoice_remain;
		
				$k = 0;
				
				foreach($parent as $parentKey => $value ) {
		
					# Sum M3
					$sum_m3_child = TransactionChild::where('transaction_parent_id','=',$value['id'])->where('product_id','>',0)->sum('quality');
					$sumProduct =  TransactionChild::where('transaction_parent_id','=',$value['id'])->where('service_id','=',null)->sum('total');
					$sumService =  TransactionChild::where('transaction_parent_id','=',$value['id'])->where('product_id','=',null)->sum('total');
		
					$sum_m3_child > 0 ? $sum_m3_child : 0;
		
					# Find Payment
					//$PaymentTotal = TransactionPayment::where('status','=',1)->where('transaction_parent_id','=',$value['id'])->sum('amount');
					$PaymentTotal = 0;
					
					# Find Transaction CHild
					$transaction_child = TransactionChild::where('transaction_parent_id',$value['id'])->get()->toArray();
		
					$c = 0;
					
					foreach( $transaction_child as $tran_child_key => $tran_child_val) {
						$c = $c + 1;
					 	
						# Find Product
						if ( $tran_child_val['product_id'] > 0 ) {
							$title = Product::find($tran_child_val['product_id'])->title;
							$unit = 'm<sup>3</sup>';
							$quality = number_format($tran_child_val['quality'],2).' '.$unit;
						} else {
							$service = Service::find($tran_child_val['service_id']);
							$title = $service->service_name;
							$unit = $service->unit;
							$quality = '('.number_format($tran_child_val['quality'],2).' '.$unit.')';
						}
						$transaction_child[$tran_child_key]['index'] = $c;
						$transaction_child[$tran_child_key]['title'] = $title;
						$transaction_child[$tran_child_key]['issue_date'] = Tool::toDateTime($tran_child_val['issue_date']);
						$transaction_child[$tran_child_key]['quality'] = $quality;
						$transaction_child[$tran_child_key]['price'] = number_format($tran_child_val['price'],2);
						$transaction_child[$tran_child_key]['total'] = number_format($tran_child_val['total'],2);
						$transaction_child[$tran_child_key]['index'] = $c;
					}

					# Find Invoice number if existed
					$invoice = TransactionInvoice::find($value['transaction_invoice_id']);
					$invoice_number = $invoice ? $invoice->invoice_number : '';
					
					$k = $k+1;

					$grand_total_html = $value['penalty'] == 1 ? number_format($value['grand_total'],2).' THB +' : number_format($value['grand_total'],2).' THB';
					
					$data[] = array(
							'id' => $value['id'],
							'index' => $k,
							'header' => 0,
							'invoice' => 0,
							'invoice_detail' => null,
							'customer' => '',
							'transaction_statusHtml' => TransactionParent::getStatusTag($value['transaction_status']),
							'transaction_status' => $value['transaction_status'],
							'invoice_status' => 0,
							'send_location' => $value['send_location'],
							'transaction_number_html' => $value['transaction_number'],
							'sum_m3_child' => $sum_m3_child.' m<sup>3</sup>',
							'grand_total_html' => $grand_total_html,
                            'invoice_number' => $invoice_number,
							'transaction_date' => Tool::toDate($value['transaction_date']),
							'transaction_childs' => $transaction_child,
					);
				}
			}

		}
		
		if( $report == true ) {
			# Push Grand sum of all to the end of array
			$data[count($data)+1] = array(
				'grand_sum_m3'=> number_format($grand_sum_m3,2),
				'grand_sum_total'=> number_format($grand_sum_total,2),
				'grand_sum_paid'=> number_format($grand_sum_paid,2),
				'grand_sum_remain'=> number_format($grand_sum_remain,2)
			);
		}

		return $data;
	}

	/**
	 * Transaction Status Tag
	 * ----------------------
	 */
	public static function getStatusTag( $status ) {
		
		switch( $status ) {

			case 1:
				$tag = '<span class="tag purple">ຄ້າງຊຳລະ</span>';
				break;
			case 2:
				$tag = '<span class="tag green">ຈ່າຍແລ້ວ</span>';
				break;
			default:
				$tag = '<span class="tag orange">ລໍຖ້າຊຳລະ</span>';
				break;
		}
		return $tag;
	}
	
	/**
	 * transaction parent string update
	 * --------------------------------
	 */
	public static function transaction_parent_str_update($type, $transaction_parent_str, $transaction_parent_id, $customer_id) {

		switch($type) {
				
			# Update new parent id to transaction_parent_str
			case 'update':

				# Find record in table "transaction_parent"
				$transaction_date = TransactionParent::find($transaction_parent_id);
				$transaction_date = $transaction_date->transaction_date;
				
				$transactionParents = TransactionParent::where('customer_id',$customer_id)->where('transaction_date','<=',date('Y-m-t',strtotime($transaction_date)))->where('transaction_date','>=',date('Y-m-01',strtotime($transaction_date)))->orderBy('transaction_date','asc')->get();
				$new_transaction_parent_str = "";
				
				foreach( $transactionParents->toArray() as $parent ) {
					$new_transaction_parent_str.= $parent['id'].'-';
				}
				
				// Make new transaction_parent_str
				$new_transaction_parent_str = rtrim($new_transaction_parent_str,'-');

			 	// Update table "transaction_invoice"
			 	DB::table('transaction_invoice')->where('transaction_parent_str',$transaction_parent_str)->update(array('transaction_parent_str'=>$new_transaction_parent_str));		 	
			 
			 	// Update table "transaction_invoice_penalty"
			 	DB::table('transaction_invoice_penalty')->where('transaction_parent_str',$transaction_parent_str)->update(array('transaction_parent_str'=>$new_transaction_parent_str));
			 	
			 	// Update table "transaction_payment"
			 	DB::table('transaction_payment')->where('transaction_parent_str',$transaction_parent_str)->update(array('transaction_parent_str'=>$new_transaction_parent_str));
			 	
			 	// Find transaction_parent
			 	$transaction_parent = TransactionParent::find($transaction_parent_id);
			 	
			 	// Find Cusomter
			 	$customer = Customer::find($transaction_parent->customer_id);

			 	// Find Latest invoice status
			 	$TransactionInvoiceCheck = TransactionInvoice::where('transaction_parent_str',$new_transaction_parent_str)->orderBy('id','desc')->get()->first()->toArray();
			 	
			 	if( $TransactionInvoiceCheck['status'] == 2) {

				 	// Create new invoice
				 	$TransactionInvoice = new TransactionInvoice();
				 	$TransactionInvoice->invoice_number = $customer->transaction_prefix.$transaction_parent_id;
					$TransactionInvoice->customer_id = $transaction_parent->customer_id;
					$TransactionInvoice->invoice_date = $transaction_parent->transaction_date;
					$TransactionInvoice->transaction_parent_str = $new_transaction_parent_str;
					$TransactionInvoice->amount = 0;
					$TransactionInvoice->status = 0;
					$TransactionInvoice->invoice_create_user_id = Auth::id();
					$TransactionInvoice->save();
			 	}

				$new_transaction_parent_str = "";
		
				break;
				
			# Remove new parent id to transaction_parent_str
			case 'remove':
				
				$TransactionInvoice = TransactionInvoice::where('transaction_parent_str','LIKE','%'.$transaction_parent_id.'%')->get();

				if( $TransactionInvoice->count() > 0 ) {
						
					foreach( $TransactionInvoice->toArray() as $row ) {

						$old_transaction_parent_str = $row['transaction_parent_str'];
						
						$new_transaction_parent_str = str_replace($transaction_parent_id,'',$row['transaction_parent_str']);
						$new_transaction_parent_str = str_replace('--','-',$new_transaction_parent_str);
						$new_transaction_parent_str = ltrim($new_transaction_parent_str,'-');
						$new_transaction_parent_str = rtrim($new_transaction_parent_str,'-');

						// Update table "transaction_invoice"
						DB::table('transaction_invoice')->where('transaction_parent_str',$old_transaction_parent_str)->update(array('transaction_parent_str'=>$new_transaction_parent_str));
					
						// Update table "transaction_invoice_penalty"
						DB::table('transaction_invoice_penalty')->where('transaction_parent_str',$old_transaction_parent_str)->update(array('transaction_parent_str'=>$new_transaction_parent_str));
		
						// Update table "transaction_payment"
						DB::table('transaction_payment')->where('transaction_parent_str',$old_transaction_parent_str)->update(array('transaction_parent_str'=>$new_transaction_parent_str));

						# Update Invoice Amount
						TransactionInvoice::amountUpdateById($row['id']);
					}


				}
				
				break;
				
			
			default:
				
				
				
				break;
				
		}
	}
	
	/**
	 * Build transaction parent str
	 * ----------------------------
	 */
	public function transaction_parent_str_rebuild($transaction_parent_str, $remove = false) {
		
		if( $remove == true ) {
			
			
			
		} else {

			
		}
		
		return $transaction_parent_str;
		
	}
	
}
