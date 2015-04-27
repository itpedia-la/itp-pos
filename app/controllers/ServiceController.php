<?php

use Illuminate\Support\Facades\Redirect;
/**
 * Service Controller
 * -------------------
 * @author Theppany
 *
 */
class ServiceController extends BaseController {
	
	/**
	 * Customer index
	 * --------------
	 *
	 * @author Theppany Thienkhanh
	 */
	public function index() {
		return View::make ( 'service.index' );
	}

	/**
	 * Add Service
	 * ---------------
	 */
	public function add() {
		return View::make ( 'service.add' );
	}
	
	/**
	 * Edit Service
	 * ---------------
	 */
	public function edit($id) {
		$service = Service::find($id);
		return View::make ( 'service.edit' )->with('service',$service);
	}
	
	/**
	 * Remove Service
	 * ---------------
	 */
	public function remove($id) {
		$service = Service::find($id);
		return View::make ( 'service.remove' )->with('service',$service);
	}
	
	/**
	 * Save Service
	 * ---------------
	 */
	public function save() {
		$rules = array (
				'service_name' => 'required',
				'price' => 'required', // required and must be unique in the ducks table
				//'currency' => 'required',
				'unit' => 'required',
				
		);
		
		$messages = array (
				'service_name.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຊື່ບໍລິການ',
				'price.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ລາຄາ',
				//'currency.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ສະກຸນເງິນ',
				'unit.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຫົວໜ່ວຍ',
				
		);
		$validator = Validator::make ( Input::all (), $rules, $messages );
		
		if ($validator->fails ()) {
				
			// get the error messages from the validator
			$messages = $validator->messages ();
				
			// redirect our cust back to the form with the errors from the validator
			return Redirect::to ( 'service/add' )->withErrors ( $validator )->with ( 'input', Input::all () );
		} else {
			
			
			$service = new Service();
			$service->service_name = Input::get('service_name');
			$service->price = Input::get('price');
			$service->currency = 'THB'; //Input::get('currency');
			$service->unit = Input::get('unit');
			$service->remark = Input::get('remark');
			$service->save();
			
			return Redirect::to ( 'service' )->with ( 'message', 'ເພີ່ມຂໍ້ມູນບໍລິການສຳເລັດ' );
		}
	}
	
	/**
	 * Update Service
	 * ---------------
	 */
	public function update() {

		$rules = array (
				'service_name' => 'required',
				'price' => 'required', // required and must be unique in the ducks table
				//'currency' => 'required',
				'unit' => 'required',
		
		);
		
		$messages = array (
				'service_name.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຊື່ບໍລິການ',
				'price.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ລາຄາ',
				//'currency.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ສະກຸນເງິນ',
				'unit.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຫົວໜ່ວຍ',
		
		);
		$validator = Validator::make ( Input::all (), $rules, $messages );
	
		if ($validator->fails ()) {
	
			// get the error messages from the validator
			$messages = $validator->messages ();
	
			// redirect our cust back to the form with the errors from the validator
			return Redirect::to ( 'service/add' )->withErrors ( $validator )->with ( 'input', Input::all () );
		} else {
				
			$service_id = Input::get('service_id');	
			$service = Service::find($service_id);
			$service->service_name = Input::get('service_name');
			$service->price = Input::get('price');
			$service->currency = Input::get('currency');
			$service->unit = Input::get('unit');
			$service->remark = Input::get('remark');
			$service->save();
				
			return Redirect::to ( 'service' )->with ( 'message', 'ແກ້ໄຂມູນບໍລິການສຳເລັດ' );
		}
	}
	
	
	/**
	 * Service List JSONP
	 * ---------------
	 */
	public function delete() {
	
		$service_id = Input::get('service_id');
		$service = Service::find($service_id);
		$service->remove = 1;
		$service->save();
		
		return Redirect::to ( 'service' )->with ( 'message', 'ລົບລ້າງມູນບໍລິການສຳເລັດ' );
	}
	
	
	/**
	 * Service List JSONP
	 * ---------------
	 */
	public function service_list_json() {
		$data = Service::where ( 'remove', 0 )->where('penalty_fee',0)->get ()->toArray ();
		
		foreach ($data as $k=>$v){
			$_data[$k] = $v;
			$_data[$k]['service_name_html'] = $v['service_name'].' / '.number_format($v['price']).' '.$v['currency'].' ('.$v['unit'].')';
			$_data[$k]['price_html'] = $v['price'].' '.strtoupper($v['currency']).' ('.$v['unit'].')';
			$_data[$k]['created_at'] = Tool::toDateTime($v['created_at']);
			$_data[$k]['updated_at'] = Tool::toDateTime($v['updated_at']);
		}

		return Response::json ( $_data )->setCallback ( Input::get ( 'callback' ) );
	}
}
