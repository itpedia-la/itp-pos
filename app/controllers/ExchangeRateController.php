<?php

use Illuminate\Http\Response;
/**
 * Exchange Rate Controller
 * ------------------------
 * @author Somwang Souksavatd
 *
 */
class ExchangeRateController extends BaseController {

	
	/**
	 * Exchange Rate Index
	 * --------------
	 * @author Theppany Thienkhanh
	 */
	public function index(){
		
		$exchange = ExchangeRate::orderby('created_at', 'desc')->first();

		return View::make('exchange.index')->with('exchange',$exchange);
	}
	
	/**
	 * Exchange Rate Save
	 * ------------------
	 * @author Theppany
	 */
	public function save(){
		
		$usd = doubleval(Input::get('usd'));
		$lak = doubleval(Input::get('lak'));
		
		$exchange = new ExchangeRate();
		$exchange->USD = $usd;
		$exchange->LAK = $lak;
		$exchange->save();
		
		return Redirect::to('exchange')->with('message','ອັດຕາແລກປ່ຽນໄດ້ຖືກບັນທຶກແລ້ວ.');
	}	
	
	
	
}
