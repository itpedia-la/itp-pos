<?php

/**
 * Report Controller
 * 
 * @author Somwang
 *
 */
class ReportController extends BaseController {

	/*
	 * Deliver Report
	 * --------------
	 * @author Somwang 
	 */
	public function delivery() {

		$date_start = Route::input('date_start') ? Tool::toMySqlDate(Route::input('date_start')) : null;
		$date_end = Route::input('date_end') ? Tool::toMySqlDate(Route::input('date_end')) : null;

		$date_start = $date_start.' 00:00:01';
		$date_end = $date_end.' 23:59:00';
		
		$data = TransactionChild::where('issue_date','>=',$date_start)->where('issue_date','<=',$date_end)->where('product_id','>',0)->where('issue_slip_id','!=','')->get()->toArray();

		$i = 0;
		$sum_quality = 0;
		
		foreach($data as $key => $value) {
			
			# Find Tran Parent
			$TranParent = TransactionParent::find($value['transaction_parent_id']);
			
			# Find Company
			$customer = Customer::find($TranParent->customer_id);
			
			$i = $i+1;
			$data[$key]['index'] = $i;
			$data[$key]['transaction_number'] = $TranParent->transaction_number;
			$data[$key]['customer_name'] = $customer->company_name;
			$data[$key]['send_location'] = $TranParent->send_location;
			$data[$key]['customer_id'] = $TranParent->customer_id;
			$data[$key]['issue_date'] = Tool::toDateTime($value['issue_date']);

			$sum_quality = $sum_quality + $value['quality'];
		}

		$sum_quality = number_format($sum_quality,2);
		
		if( Input::get('print') == true ) {
			
			$company = CompanyProfile::find(1);
			$user = User::find(Auth::id());
			$user = $user->firstname.' '.$user->lastname;
			return View::make('report/delivery_print')->with('data',$data)->with('company',$company)->with('user',$user)->with('sum_quality',$sum_quality);
			
		} else {
			
			return View::make('report/delivery')->with('data',$data)->with('sum_quality',$sum_quality);
		}

	}
	
	/*
	 * Material Report by Customer
	 * ---------------------------
	 * @author Somwang
	 */
	public function material_customer() {
		
		$date_start = Route::input('date_start') ? Tool::toMySqlDate(Route::input('date_start')) : null;
		$date_end = Route::input('date_end') ? Tool::toMySqlDate(Route::input('date_end')) : null;
		
		$date_start = $date_start.' 00:00:01';
		$date_end = $date_end.' 23:59:00';
		
		$data = TransactionChild::groupBy('transaction_parent_id')->groupBy('product_id')->where('issue_date','>=',$date_start)->where('issue_date','<=',$date_end)->where('product_id','>',0)->get()->toArray();

		
		$i = 0;
		
		$total_qty = 0;
		$total_rock = 0;
		$total_sand = 0;
		$total_water = 0;
		$total_cm_1 = 0;
		$total_cm_2 = 0;
		$total_cm_3 = 0;
		$total_cm_4 = 0;
		$total_cm_5 = 0;
		$total_cm_6 = 0;
		$total_adx_1 = 0;
		$total_adx_2 = 0;
		$total_adx_3 = 0;
		
		foreach( $data as $key => $value ) {
		
			$i = $i+1;
		
			# Find Parent
			$TranParent = TransactionParent::find($value['transaction_parent_id']);
		
			# Find Customer
			$Customer = Customer::find($TranParent->customer_id);

			# Find Product Code
			$Product = Product::find($value['product_id']);

			# Sum Quality
			$quality = TransactionChild::where('transaction_parent_id','=',$value['transaction_parent_id'])->where('product_id','=',$value['product_id'])->where('issue_date','>=',$date_start)->where('issue_date','<=',$date_end)->sum('quality');

			# Sum Rock
			$rock = $quality * $Product->crashed_stone_kg / 1000;

			# Sum Sand
			$sand = $quality * $Product->sand_kg / 1000;

			# Sum Water
			$water = $quality * $Product->water_litre;

			# Sum Cement 1
			$cement_1 = $quality * $Product->cement_1_kg / 1000;

			# Sum Cement 2
			$cement_2 = $quality * $Product->cement_2_kg / 1000;

			# Sum Cement 3
			$cement_3 = $quality * $Product->cement_3_kg / 1000;

			# Sum Cement 4
			$cement_4 = $quality * $Product->cement_4_kg / 1000;

			# Sum Cement 5
			$cement_5 = $quality * $Product->cement_5_kg / 1000;

			# Sum Cement 6
			$cement_6 = $quality * $Product->cement_6_kg / 1000;

			# Admixture 1
			$adx_1 = $quality * $Product->admixture_1_cc / 1000;

			# Admixture 2
			$adx_2 = $quality * $Product->admixture_2_cc / 1000;

			# Admixture 3
			$adx_3 = $quality * $Product->admixture_3_cc / 1000;

			$data[$key]['index'] = $i;
			$data[$key]['customer'] = $Customer->company_name;
			$data[$key]['product'] = $Product->title.' ('.$value['product_id'].')';
			$data[$key]['quality'] = $quality;
			$data[$key]['rock'] = number_format($rock,3);
			$data[$key]['sand'] = number_format($sand,3);
			$data[$key]['water'] = number_format($water);
			$data[$key]['cement_1'] = number_format($cement_1,3);
			$data[$key]['cement_2'] = number_format($cement_2,3);
			$data[$key]['cement_3'] = number_format($cement_3,3);
			$data[$key]['cement_4'] = number_format($cement_4,3);
			$data[$key]['cement_5'] = number_format($cement_5,3);
			$data[$key]['cement_6'] = number_format($cement_6,3);
			$data[$key]['adx_1'] = number_format($adx_1,2);
			$data[$key]['adx_2'] = number_format($adx_2,2);
			$data[$key]['adx_3'] = number_format($adx_3,2);
			
			$total_qty = $total_qty + $quality;
			$total_rock = $total_rock + $rock;
			$total_sand = $total_sand + $sand;
			$total_water = $total_water + $water;
			$total_cm_1 = $total_cm_1 + $cement_1;
			$total_cm_2 = $total_cm_2 + $cement_2;
			$total_cm_3 = $total_cm_3 + $cement_3;
			$total_cm_4 = $total_cm_4 + $cement_4;
			$total_cm_5 = $total_cm_5 + $cement_5;
			$total_cm_6 = $total_cm_6 + $cement_6;
			$total_adx_1 = $total_adx_1 + $adx_1;
			$total_adx_2 = $total_adx_2 + $adx_2;
			$total_adx_3 = $total_adx_3 + $adx_3;
		}
		
		# Sum All
		$sum = array(
			'total_qty' => number_format($total_qty,2),
			'total_rock' => number_format($total_rock,3),
			'total_sand' => number_format($total_sand,3),
			'total_water' => number_format($total_water),
			'total_cm_1' => number_format($total_cm_1,3),
			'total_cm_2' => number_format($total_cm_2,3),
			'total_cm_3' => number_format($total_cm_3,3),
			'total_cm_4' => number_format($total_cm_4,3),
			'total_cm_5' => number_format($total_cm_5,3),
			'total_cm_6' => number_format($total_cm_6,3),
			'total_adx_1' => number_format($total_adx_1,2),
			'total_adx_2' => number_format($total_adx_2,2),
			'total_adx_3' => number_format($total_adx_3,2),
		);
		
		if( Input::get('print') == true ) {
				
			$company = CompanyProfile::find(1);
			$user = User::find(Auth::id());
			$user = $user->firstname.' '.$user->lastname;
			return View::make('report/material_customer_print')->with('data',$data)->with('company',$company)->with('user',$user)->with('sum',$sum);
				
		} else {
	
			return View::make('report/material_customer')->with('data',@$data)->with('sum',$sum);
		}
	}
	
	/**
	 * Report Transaction
	 * ------------------
	 */
	public function transaction() {
		
		$start_date = date('Y-m-01', strtotime(Route::input('month')));
			
		$end_date = date('Y-m-t', strtotime(Route::input('month')));
		
		$data = TransactionParent::getData($start_date, $end_date, true);

		if( Input::get('print') == true ) {
			
			$company = CompanyProfile::find(1);
			$user = User::find(Auth::id());
			$user = $user->firstname.' '.$user->lastname;
			
			return View::make('report/transaction_print')->with('data',$data)->with('company',$company)->with('user',$user)->with('date',array('start_date'=>$start_date,'end_date'=>$end_date));
			
		} else {
	
			return View::make('report/transaction')->with('data',$data);
		}
		
	}
	/*public function transaction() {
		
		$date_start = Route::input('date_start') ? Tool::toMySqlDate(Route::input('date_start')) : null;
		$date_end = Route::input('date_end') ? Tool::toMySqlDate(Route::input('date_end')) : null;
		
		$data = TransactionParent::where('transaction_date','>=',$date_start)->where('transaction_date','<=',$date_end)->where('transaction_status','>',0)->get()->toArray();
		
		$i = 0;

		$sum_grand_total = 0;
		$sum_paid = 0;
		$sum_remaining = 0;
		$quality = 0;
		$sum_m3 = 0;
		foreach( $data as $key => $value ) {
			
			# Find USer
			$user = User::find($value['created_by']);
			
			# Find Customer 
			$Customer = Customer::find($value['customer_id']);
			
			# Paid
			//$Paid = TransactionPayment::where('transaction_parent_id','=',$value['id'])->where('status','=',1)->sum('amount');
			$Paid = 0;
			
			# Remaining
			$Remaining = $value['grand_total'] - $Paid;
			
			$i = $i+1;
			$data[$key]['index'] = $i;
			$data[$key]['customer'] = $Customer->company_name.' ('.$Customer->id.')';
			//$data[$key]['grand_total'] = number_format($value['grand_total'],2);
			//$data[$key]['paid'] = number_format($Paid,2);
			//$data[$key]['remaining'] = number_format($Remaining,2);
			//$data[$key]['transaction_date'] = Tool::toDate($value['transaction_date']);
			//$data[$key]['created_by'] = $user->firstname;
			
			# Find Tran Child
			$Child =  TransactionChild::where('transaction_parent_id',$value['id'])->get()->toArray();
			
			$x = 0;
		
			foreach( $Child as $ChildKey => $ChildValue) {
			    $x = $x + 1;
			    
			    #Find Product
			    
			    if( $ChildValue['product_id'] > 0 ) {
			        $title = Product::find($ChildValue['product_id']);
			        $title = $title->title.' ('.$title->id.')';
			        $issue_date =  Tool::toDateTime($ChildValue['issue_date']);
			        $unit = ' m<sup>3</sup>';
			        $quality = $quality + $ChildValue['quality'];
			    } else {
			        $title = Service::find($ChildValue['service_id']);
			        $title = $title->service_name;
			        $issue_date = '';
			        $unit = '';
			    }

			    $Child[$ChildKey]['footer'] = false;
			    $Child[$ChildKey]['index'] = $x;
			    $Child[$ChildKey]['title'] = $title;
			    $Child[$ChildKey]['issue_slip_id'] = $ChildValue['issue_slip_id'];
			    $Child[$ChildKey]['quality'] = number_format($ChildValue['quality'],2).$unit;
			    $Child[$ChildKey]['price'] = number_format($ChildValue['price'],2);
			    $Child[$ChildKey]['total'] = number_format($ChildValue['total'],2);
			    $Child[$ChildKey]['issue_date'] = $issue_date;

			    
			}
			
			//$Childs['']
	
			$data[$key]['childs'] = $Child;
			$data[$key]['childs'][count($Child)]['footer'] = true;
			$data[$key]['childs'][count($Child)]['quality'] = number_format($quality,2);
			$data[$key]['childs'][count($Child)]['grand_total'] = number_format($value['grand_total'],2);
			$data[$key]['childs'][count($Child)]['paid'] = number_format($Paid,2);
			$data[$key]['childs'][count($Child)]['remaining'] = number_format($Remaining,2);
			$data[$key]['childs'][count($Child)]['style'] = ' style="background:#FFFEE3; color:#000" ';
			
			$sum_m3 = $sum_m3 + $quality;
			
			$quality = 0;
			$sum_grand_total = $sum_grand_total + $value['grand_total'];
			$sum_paid = $sum_paid + $Paid;
			$sum_remaining = $sum_remaining + $Remaining;
			
			
			
		}
		
		# Sum All
		$sum = array(
			'sum_m3' => number_format($sum_m3,2),
			'sum_grand_total' => number_format($sum_grand_total,2),
			'sum_paid' => number_format($sum_paid,3),
			'sum_ramaining' => number_format($sum_remaining,3),
		);
		

		if( Input::get('print') == true ) {
			
			$company = CompanyProfile::find(1);
			$user = User::find(Auth::id());
			$user = $user->firstname.' '.$user->lastname;
			
			return View::make('report/transaction_print')->with('data',$data)->with('company',$company)->with('user',$user)->with('sum',@$sum);
			
		} else {
	
			return View::make('report/transaction')->with('data',@$data)->with('sum',@$sum);
		}
	}*/
	
	/*
	 * Service Report
	 * 
	 */
	public function service() {
	    
	    $date_start = Route::input('date_start') ? Tool::toMySqlDate(Route::input('date_start')) : null;
	    $date_end = Route::input('date_end') ? Tool::toMySqlDate(Route::input('date_end')) : null;
	    
	    $date_start = $date_start.' 00:00:01';
	    $date_end = $date_end.' 23:59:00';
	    
	    $data = TransactionChild::groupBy('transaction_parent_id')->groupBy('service_id')->where('created_at','>=',$date_start)->where('created_at','<=',$date_end)->where('service_id','>',0)->get()->toArray();
	    	
	    $i = 0;

	    //$sumQuality = 0;
	    $sumTotal = 0;
	    
	    foreach( $data as $key => $value ) {

	        $i = $i+1;
		
			# Find Parent
			$TranParent = TransactionParent::find($value['transaction_parent_id']);
		
			# Find Customer
			$Customer = Customer::find($TranParent->customer_id);

			# Find Product Code
			$Service = Service::find($value['service_id']);

			# Sum Quality
			$quality = TransactionChild::where('service_id','=',$value['service_id'])->where('created_at','>=',$date_start)->where('created_at','<=',$date_end)->sum('quality');
			
			$data[$key]['index'] = $i;
			$data[$key]['customer'] = $Customer->company_name;
			$data[$key]['service_name'] = $Service->service_name;
			$data[$key]['price'] = number_format($value['price'],2);
			$data[$key]['total'] = number_format($value['total'],2);
		    $data[$key]['quality'] = number_format($value['quality'],2).' '.$Service->unit;
			//$sumQuality = $sumQuality + $value['quality'];
			$sumTotal = $sumTotal + $value['total'];
	     } 
	     
	     # Sum All
	     $sum = array(
    	     'sum_total' => number_format($sumTotal,2),
    	    // 'sum_quality' => number_format($sumQuality,2),
	     );
	     

        if( Input::get('print') == true ) {
    
	        $company = CompanyProfile::find(1);
	        $user = User::find(Auth::id());
	        $user = $user->firstname.' '.$user->lastname;
	        return View::make('report/service_print')->with('data',$data)->with('company',$company)->with('user',$user)->with('sum',@$sum);
    
	    } else {
	    
	        return View::make('report/service')->with('data',@$data)->with('sum',@$sum);
	    }
	   
	    
	    
	}
	
	/*
	 * Report Payment
	 * --------------
	 */
	public function payment() {
		
		$date_start = Route::input('date_start') ? Tool::toMySqlDate(Route::input('date_start')) : null;
		$date_end = Route::input('date_end') ? Tool::toMySqlDate(Route::input('date_end')) : null;
		
		$data = TransactionPayment::groupBy('transaction_parent_id')->where('payment_date','>=',$date_start)->where('payment_date','<=',$date_end)->get()->toArray();
		
		$i = 0;
		foreach( $data as $key => $value ) {
			
			# Find Payment
			$payment = TransactionPayment::getData($value['transaction_parent_id']);
			
			$x = 0;
			foreach( $payment as $paymentKey => $paymentValue) {
				$x = $x +1;
				
				# Find Receiver 
				$Receiver = $paymentValue['received_by'] > 0 ? User::find($paymentValue['received_by']) : '';
				
				$payment[$paymentKey]['index'] = $x;
				$payment[$paymentKey]['paid_at'] = $paymentValue['paid_at'] ? Tool::toDate($paymentValue['paid_at']) : '';
				$payment[$paymentKey]['payment_date'] = Tool::toDate($paymentValue['payment_date']);
				$payment[$paymentKey]['payment_due_date'] = Tool::toDate($paymentValue['payment_due_date']);
				$payment[$paymentKey]['receiver'] = $paymentValue['received_by'] > 0 ?  $Receiver->firstname.' '.$Receiver->lastname : '';
			}
			
			# Find Transaction Parent
			$TransactionParent = TransactionParent::find($value['transaction_parent_id']);
			
			# Find Customer
			$Customer = Customer::find($TransactionParent->customer_id);

			# Find User
			$User = User::find($TransactionParent->created_by);
		
			$i = $i + 1;
			
			$result[$key]['index'] = $i;
			$result[$key]['transaction_number'] = $TransactionParent->transaction_number;
			$result[$key]['customer'] = $Customer->company_name;
			$result[$key]['payment'] = $payment;
			$result[$key]['transaction_date'] = Tool::toDate($TransactionParent->transaction_date);
			$result[$key]['user'] = $User->firstname.' '.$User->lastname;
			
		}
		
		/*echo '<pre>';
		print_r($result);
		echo '</pre>';
		exit();*/

		if( Input::get('print') == true ) {
		
			$company = CompanyProfile::find(1);
			$user = User::find(Auth::id());
			$user = $user->firstname.' '.$user->lastname;
			return View::make('report/payment_print')->with('data',@$result)->with('company',$company)->with('user',$user)->with('sum',@$sum);
		
		} else {
			 
			return View::make('report/payment')->with('data',@$result)->with('sum',@$sum);
		}
	}

}
