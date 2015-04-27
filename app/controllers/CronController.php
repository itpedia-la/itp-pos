<?php

class CronController extends Controller {	
	
	
	/**
	 * Overdue Invoice Charge
	 * ----------------------
	 */
	public static function overdueInvoiceCharge() {

		$invoices = TransactionInvoice::where('invoice_penalty_date','=',date('Y-m-d'))->where('status','=',1)->get();

		if( $invoices->count() > 0 ) {
			
			$invoices = $invoices->toArray();
			
			$i = 0;
			
			# Loop Invoices
			foreach( $invoices as $row ) 
			{
				
				# Find Customer
				$Customer = Customer::find($row['customer_id']);
				
				# Add Penalty 
				$Penalty = new TransactionInvoicePenalty();
				$Penalty->transaction_invoice_id = $row['id'];
				#$Penalty->amount_total = $row['amount'];
				$Penalty->transaction_parent_str = $row['transaction_parent_str'];

				# Total Amount
				$amount = $row['amount'];
				
				# Customer
				$penalty_percentage = $Customer->overpaid_charge_percentage;
				
				# Calc Penalty amount
				$penalty_amount = $amount * $penalty_percentage / 100;
				
				# Grand Total
				$grand_amount = $amount + $penalty_amount;
				
				echo 'Total: '.$amount.'<br/>';
				echo 'Penalty Amount: '.$penalty_amount.' ('.$penalty_percentage.'%)<br/>';
				echo 'Grand Total: '.$grand_amount;
				
				//exit();
				
				$Penalty->amount_total = $amount;
				$Penalty->percentage_of_penalty = $penalty_percentage;
				$Penalty->amount_penalty = $penalty_amount;
				
				/*switch($Customer->customer_type)
				{
					# 15 Days Customer type
					case 15:
					
						
						break;
						
					# 45 Days Customer Type
					case 30:
					case 45:

						# Customer
						$penalty_percentage = $Customer->overpaid_charge_percentage;
						
						# Calc Penalty amount
						$penalty_amount = $amount * $penalty_percentage / 100;
						
						# Grand Total
						$grand_amount = $amount + $penalty_amount;
						
						echo 'Total: '.$amount.'<br/>';
						echo 'Penalty Amount: '.$penalty_amount.' ('.$penalty_percentage.'%)<br/>';
						echo 'Grand Total: '.$grand_amount;
						
						//exit();
						
						$Penalty->amount_total = $amount;
						$Penalty->percentage_of_penalty = $penalty_percentage;
						$Penalty->amount_penalty = $penalty_amount;
						
						break;
						
					default:
						
						$grand_amount = $amount;
						
						break;
				}*/
				
				# Update Expired Invoice
				$InvoiceUpdate = TransactionInvoice::find($row['id']);
				$InvoiceUpdate->amount = $amount;
				$InvoiceUpdate->status = 3;
				$InvoiceUpdate->save();
				
				# Create New Invoice with status = 0;
				$new_invoice = new TransactionInvoice();
				$new_invoice->customer_id = $row['customer_id'];
				#$new_invoice->invoice_number = $row['invoice_number'];
				$new_invoice->status = 0;
				$new_invoice->transaction_parent_str = $row['transaction_parent_str'];

				$new_invoice->amount = $grand_amount;
				$new_invoice->save();
				
				# Update latest Invoice
				$update_invoice = TransactionInvoice::find($new_invoice->id);
				$update_invoice->invoice_number = Customer::find($row['customer_id'])->transaction_prefix.$new_invoice->id;
				$update_invoice->save();
				
				# Save Penalty Info
				$Penalty->save();
				
			}
			
			echo '<br/>Done...!';
			
		/*	echo '<pre>';
			print_r($invoices);
			echo '</pre>';
			exit();*/
		}
		
	}
	
	
	/**
	 * Overpaid Penalty Charge by transacitonParent
	 * --------------------------------------------
	 */
	public static function overpaidPenaltyCharge() {
		
		# Find transaction parent where penalty date = today
		$TransactionParents = TransactionParent::where('next_penalty_date','=',date('Y-m-d'))->where('transaction_status','!=',3)->get();
		
		/*echo '<pre>';
		print_r($TransactionParents);
		echo '</pre>';
		exit();*/
		
		if( $TransactionParents->count() > 0 ) {
			
			$i = 0;
			
			foreach( $TransactionParents as $TransactionParent) {
	
				$i = $i + 1;
				
				# Find Customer Type
				$Customer = Customer::find($TransactionParent->customer_id);
				
				$CustomerType = $Customer->customer_type;
				
				# Set next_penalty_date
				$next_penalty_date = strtotime("+".$TransactionParent->dept_duration." days", strtotime(date('Y-m-d')));
				
				$next_penalty_date = date("Y-m-d",$next_penalty_date);
				
				# Insert penalty as Service
				$tran_child = new TransactionChild();
				$tran_child->issue_date = date('Y-m-d');
				$tran_child->transaction_parent_id = $TransactionParent->id;
				
		
					switch( $CustomerType ) {
						
						# 15 days type
						# ------------
						case 15: 
							
								$service_id = 15;
								
								# Find Quality
								$quality = TransactionChild::where('transaction_parent_id','=',$TransactionParent->id)->where('issue_slip_id','!=','')->sum('quality');
								
								# Calcucate penalty cost
								$penaltyCost = $TransactionParent->penalty_fee_m3 * $quality;
								
								$tran_child->quality = $quality;
								$tran_child->total = $penaltyCost;
								$tran_child->price = $TransactionParent->penalty_fee_m3;
	
								$amount = $quality.' m3';
								
								$customer_type = '15 - '.$TransactionParent->penalty_fee_m3.' (m3)';
								
							break;
	
						
						# 45 days type ( default )
						# ------------------------
						default: 
								
								$service_id =16;
							
								# Find Total
								$total = TransactionChild::where('transaction_parent_id','=',$TransactionParent->id)->where('issue_slip_id','!=','')->sum('total');
							
								# Calculate penalty cost
								$penaltyCost =  ( $TransactionParent->overpaid_charge_percentage * $total ) / 100 ;
								
								$tran_child->quality = $TransactionParent->overpaid_charge_percentage;
								$tran_child->total = $penaltyCost;
								$tran_child->price = $penaltyCost;
	
								$amount = number_format($total,2).' THB';
								
								$customer_type = '45 - '.$TransactionParent->overpaid_charge_percentage.' (%)';
								
							break;
					}
					
					# Collecting the result into array
					$result[] = array(
						'customer_name' => $Customer->company_name,
						'customer_type' => $customer_type,
						'transaction_parent_id' => $TransactionParent->id,
						'title' => Service::find($service_id)->service_name,
						'amount' => $amount,
						'next_penalty_date' => Tool::toDate($next_penalty_date),
						'penalty_cost' => number_format($penaltyCost,2).' THB',
					);
					
					$tran_child->service_id = $service_id;
					$tran_child->save();
					
					# Update Transaction Parent Total
					$sumTranChild = TransactionChild::where('transaction_parent_id','=',$TransactionParent->id)->sum('total');
					
					$TranParent = TransactionParent::find($TransactionParent->id);
					$TranParent->next_penalty_date = $next_penalty_date;
					$TranParent->grand_total = $sumTranChild;
					$TranParent->penalty = 1;
					$TranParent->save();
					
					# Update Invoice Amount
					TransactionInvoice::amountUpdate($TransactionParent->id);

			}
			
			# Set subject of email
			$subject = 'FMG Cron - ລາຍການປັບໄຫນລູກຄ້າ ຄ້າງຊຳລະປະຈຳວັນທີ '.date('d-M-Y').' - '.$i.' ລາຍການ';
			
			# Display result
			/*echo '<pre>';
			print_r($result);
			echo '</pre>';*/
			
			# Send Email notification
			Mail::send('emails.cron_penalty', array('result'=>$result), function($message) use ($subject)
			{
				$message->from('km10@fmglaos.com', 'FMG - KM10');
				$message->to('dsouksavatd@gmail.com', 'Somwang Souksavatd')->subject($subject);
			});
			
			echo 'Done...!';
			
		} else {
			
			echo 'Nothing transaction to penalty.';
			
			
		}
		
	}
	
	/**
	 * DB Fix
	 * ------
	 */
	public function db_fix() {
		
		# Update Invoice
		TransactionInvoice::where('status',1)->update(array('status'=>0));
		TransactionInvoice::where('status',2)->update(array('status'=>0));
		
		TransactionInvoice::where('status',0)->update(array('invoice_create_user_id'=>14));
		
		# Update Customer Type
		$customer = Customer::all()->toArray();
		foreach( $customer as $row ) {
			$updateCustomer = Customer::find($row['id']);
			$updateCustomer->customer_type = $row['dept_duration'];
			$updateCustomer->save();
		}
		
		# Update Invoice - invoice_date
		$invoices = TransactionInvoice::all()->toArray();
		foreach( $invoices as $row ) {
			$updateInvoice = TransactionInvoice::find($row['id']);
			$updateInvoice->invoice_date = date('Y-m-d',strtotime($row['created_at']));
			$updateInvoice->save();
		}
	}
	
	
	
}