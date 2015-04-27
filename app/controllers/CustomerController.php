<?php

/**
 * Dashboard Controller
 * -------------------
 * @author Theppany
 *
 */
class CustomerController extends BaseController {
	
	/**
	 * Customer index
	 * --------------
	 *
	 * @author Theppany Thienkhanh
	 */
	public function index() {
		return View::make ( 'customer.index' );
	}
	
	/**
	 * Customer List JSONP
	 * ---------------
	 */
	public function CustomerListJson() {
		$data = Customer::where ( 'remove', 0 )->get ()->toArray ();
		foreach( $data as $key => $value ) {
			$data[$key]['dept_duration'] = $value['dept_duration'].' ມື້';
			$data[$key]['overpaid_charge_percentage'] = $value['overpaid_charge_percentage'].' %';
			$data[$key]['penalty_fee_m3'] = $value['penalty_fee_m3'] > 0 ? number_format($value['penalty_fee_m3'],2).' THB' : '0 THB';
		}
		return Response::json ( $data )->setCallback ( Input::get ( 'callback' ) );
	}
	
	/**
	 * Customer Add
	 * ---------------
	 */
	public function add() {
		return View::make ( 'customer.add' );
	}
	
	
	/**
	 * Customer Remove
	 * ---------------
	 */
	public function remove($id) {
		$customer = Customer::find($id);
		return View::make('customer.remove')->with('customer',$customer);
	}
	
	/**
	 * Customer Delete
	 * ---------------
	 */
	public function delete() {
		$cust_id = Input::get('cust_id');
		
		$customer = Customer::find($cust_id);
		$customer->remove = 1;
		$customer->save();
		return Redirect::to ( 'customer' )->with ( 'message', 'ລຶບຂໍ້ມູນລູກຄ້າສຳເລັດ' );
	
	}
	
	
	/**
	 * Customer Edit
	 * ---------------
	 */
	public function edit($id) {
		$customer = Customer::find($id);
		return View::make ( 'customer.edit' )->with('customer',$customer);
	}
	
	
	/**
	 * Customer Update
	 * ---------------
	 */
	public function update() {

		$rules = array (
				'company_name' => 'required',
				//'contact_name' => 'required', // required and must be unique in the ducks table
				//'address' => 'required',
				'transaction_prefix' => 'required',
				//'telephone' => 'required',
				//'mobile' => 'required',
				//'send_location'=>'required',
				'dept_duration' => 'required',
				//'overpaid_charge_percentage' => 'required',
		);
		
		$messages = array (
				'company_name.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ບໍລິສັດ',
				//'contact_name.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຜູ້ຕິດຕໍ່',
				//'transaction_prefix.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ລະຫັດຫົວບິນ',
				//'address.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ທີ່ຢູ່',
				//'telephone.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ເບີໂທ',
				//'mobile.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ເບີມືຖື',
				//'send_location.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ສະຖານທີ່ສົ່ງ',
				'dept_duration.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ໄລຍະເວລາຊຳລະຫນີ້',
				//'overpaid_charge_percentage.required' => 'ອ/ຕ ດອກເບ້ຍ ຄ້າງຊຳລະ',
		);
		
		$validator = Validator::make ( Input::all (), $rules, $messages );
		
		if ($validator->fails ()) {
			
			// get the error messages from the validator
			$messages = $validator->messages ();
			
			// redirect our cust back to the form with the errors from the validator
			return Redirect::to ( 'customer/edit/'.Input::get('cust_id') )->withErrors ( $validator )->with ( 'input', Input::all () );
		} else {
			
			$customer = Customer::find(Input::get('cust_id'));
			//$customer->customer_type = Input::get ( 'customer_type' );
			$customer->company_name = Input::get ( 'company_name' );
			$customer->transaction_prefix = Input::get('transaction_prefix');
			$customer->contact_name = Input::get ( 'contact_name' );
			$customer->address = Input::get ( 'address' );
			$customer->telephone = Input::get ( 'telephone' );
			$customer->fax = Input::get ( 'fax' );
			$customer->mobile = Input::get ( 'mobile' );
			$customer->email = Input::get ( 'email' );
			$customer->send_location = Input::get ( 'send_location' );
			$customer->dept_duration = Input::get ( 'dept_duration' );
			//$customer->penalty_fee_m3 = Input::get('penalty_fee_m3');
			$customer->overpaid_charge_percentage = Input::get ( 'overpaid_charge_percentage' );
			$customer->save();
			
			return Redirect::to ( 'customer' )->with ( 'message', 'ແກ້ໄຂຂໍ້ມູນລູກຄ້າສຳເລັດ' );
		}
	}
	
	
	/**
	 * Customer Save
	 * ---------------
	 */
	public function save() {
		$rules = array (
				'company_name' => 'required',
				//'contact_name' => 'required', // required and must be unique in the ducks table
				//'address' => 'required',
				//'transaction_prefix' => 'required',
				//'telephone' => 'required',
				//'mobile' => 'required',
				//'send_location'=>'required',
				'dept_duration' => 'required',
				//'overpaid_charge_percentage' => 'required',
		);
		
		$messages = array (
				'company_name.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ບໍລິສັດ',
				//'contact_name.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຜູ້ຕິດຕໍ່',
				//'transaction_prefix.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ລະຫັດຫົວບິນ',
				//'address.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ທີ່ຢູ່',
				//'telephone.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ເບີໂທ',
				///'mobile.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ເບີມືຖື',
				//'send_location.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ສະຖານທີ່ສົ່ງ',
				'dept_duration.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ໄລຍະເວລາຊຳລະຫນີ້',
				//'overpaid_charge_percentage.required' => 'ອ/ຕ ດອກເບ້ຍ ຄ້າງຊຳລະ',
		);
		$validator = Validator::make ( Input::all (), $rules, $messages );
		
		if ($validator->fails ()) {
			
			// get the error messages from the validator
			$messages = $validator->messages ();
			
			// redirect our cust back to the form with the errors from the validator
			return Redirect::to ( 'customer/add' )->withErrors ( $validator )->with ( 'input', Input::all () );
		} else {
			$customer = new Customer ();
			//$customer->customer_type = Input::get ( 'customer_type' );
			$customer->company_name = Input::get ( 'company_name' );
			$customer->transaction_prefix = Input::get('transaction_prefix');
			$customer->contact_name = Input::get ( 'contact_name' );
			$customer->address = Input::get ( 'address' );
			$customer->telephone = Input::get ( 'telephone' );
			$customer->fax = Input::get ( 'fax' );
			$customer->mobile = Input::get ( 'mobile' );
			$customer->email = Input::get ( 'email' );
			//$customer->send_location = Input::get ( 'send_location' );
			//$customer->penalty_fee_m3 = Input::get('penalty_fee_m3');
			$customer->dept_duration = Input::get ( 'dept_duration' );
			$customer->overpaid_charge_percentage = Input::get ( 'overpaid_charge_percentage' );
			$customer->save();
			
			return Redirect::to ( 'customer' )->with ( 'message', 'ເພີ່ມຂໍ້ມູນລູກຄ້າສຳເລັດ' );
		}
	}
	
	/**
	 * Get Customer info by Id
	 * -----------------------
	 * @author Somwang
	 */
	function CustomerDatJsonById() {
		$customer_id = Route::input('customer_id');
		
		$data = Customer::where('id','=',$customer_id)->get()->toArray();
		$data = $data[0];
	
		return Response::json ( $data )->setCallback ( Input::get ( 'callback' ) );
	}
}
