<?php

/**
 * Company Profile Controller
 * --------------------------
 * @author Theppany
 *
 */
class CompanyProfileController extends BaseController {

	
	/**
	 * Company Profile Index
	 * ---------------------
	 * @author Theppany
	 */
	public function index()
	{
		$profile  = CompanyProfile::first();
		return View::make('profile.index')->with('profile',$profile);
	}
	
	/**
	 * Company Profile Update
	 * ----------------------
	 * @author Theppany
	 */
	public function update(){
		
		$logo = Input::get('logo');
		
		if (Input::hasFile('logo')) {
			$file            = Input::file('logo');
			$destinationPath = 'img/';
			$filename        = str_random(6) . '_' . md5(uniqid()).'.'.Input::file('logo')->getClientOriginalExtension();
			$uploadSuccess   = $file->move($destinationPath, $filename);
			$logo = $filename;
		}

		$rules = array (
				'company_name' => 'required',
				'address' => 'required',
				'telephone' => 'required',
				'mobile' => 'required',
				'email' => 'required',
		);
		
		$messages = array (
				'company_name.required' => 'ກະລຸນປ້ອນຂໍ້ມູນ ບໍລິສັດ',
				'address.required' => 'ກະລຸນປ້ອນຂໍ້ມູນ ທີ່ຢູ່',
				'telephone.required' => 'ກະລຸນປ້ອນຂໍ້ມູນ ເບີໂທ',
				'mobile.required' => 'ກະລຸນປ້ອນຂໍ້ມູນ ເບີມືຖື',
				'email.required' => 'ກະລຸນປ້ອນຂໍ້ມູນ ອີເມວລ',
		);
		
		$validator = Validator::make ( Input::all (), $rules, $messages );
		
		if ($validator->fails ()) {
				
			// get the error messages from the validator
			$messages = $validator->messages ();
				
			// redirect our cust back to the form with the errors from the validator
			return Redirect::to ( 'customer/edit/'.Input::get('cust_id') )->withErrors ( $validator )->with ( 'input', Input::all () );
		} else {
				
			$profile = CompanyProfile::find(Input::get('profile_id'));
			$profile->company_name = Input::get ( 'company_name' );
			$profile->address = Input::get('address');
			$profile->telephone = Input::get ( 'telephone' );
			$profile->mobile = Input::get ( 'mobile' );
			$profile->logo = $logo;
			$profile->fax = Input::get ( 'fax' );
			$profile->email = Input::get ( 'email' );
			
			$profile->save();
				
			return Redirect::to ( 'profile' )->with ( 'message', 'ແກ້ໄຂຂໍ້ມູນບ່ລິສັດສຳເລັດ' );
		}
		
		
	}

}
