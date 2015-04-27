<?php

class OptionController extends Controller {


	/**
	 * Currency List
	 * ------------------
	 * @author Theppany
	 */
	public function currency(){
	
		$data = Config::get('constants.currency');
		echo json_encode($data);
	}
	
	/**
	 * Unit List
	 * ------------------
	 * @author Theppany
	 */
	public function unit(){
	
		$data = Config::get('constants.unit');
		echo json_encode($data);
	}
	
	
	
}
