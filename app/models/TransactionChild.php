<?php

/**
 * Transaction Child Model
 * -------------------
 * @author Somwang 
 *
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TransactionChild extends Eloquent {

	use SoftDeletingTrait;
	
	protected $table = 'transaction_child';

	/**
	 * Get Transaction Child with rebuild array
	 * ----------------------------------------
	 * @return unknown
	 */
	public static function getDataByParentId($TransactionParentId) {
		
		$Child = TransactionChild::where('transaction_parent_id','=',$TransactionParentId)->orderBy('id','asc')->get()->toArray();
		
		$i = 0;
		if( $Child ) {
			$TranParent = TransactionParent::find($Child[0]['transaction_parent_id']);
		}
		
		foreach( $Child as $key => $value ) {
			$i = $i+1;
			
			# Find Product
			if( $value['product_id'] > 0 ) {
				$Product = Product::find($value['product_id']);
				$title = $Product->title;
				$date = $value['issue_date'] ? '<span class="tag light-gray-bordered">'.Tool::toDate($value['issue_date']).'</span>' : '';
				$date = $date;
				$unit = 'm<sup>3</sup>';
			} else {
				
				$Service = Service::find($value['service_id']);
				$title = $Service->service_name;
				//$date = $TranParent->transaction_status == 0 ? '' : '<span class="tag light-gray-bordered">'.Tool::toDate($value['created_at']).'</span>';
				$date = '';
				$unit = $Service->unit;
			}
		
			$Child[$key]['index'] = $i;
			$Child[$key]['penalty'] = 0;
			$Child[$key]['quality'] = $value['quality'].' '.$unit;
			$Child[$key]['total'] = number_format($value['total']).' THB';
			$Child[$key]['price'] = number_format($value['price']).' THB';
			$Child[$key]['title'] = $title;
			$Child[$key]['date'] = '<span class="tag light-gray-bordered">'.Tool::toDateTime($value['issue_date']).'</span>';
			$Child[$key]['created_at'] = Tool::toDateTime($value['created_at']);
			$Child[$key]['updated_at'] = Tool::toDateTime($value['updated_at']);

		}
		
		return $Child;
	}

}
