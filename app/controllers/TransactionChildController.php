<?php 

	/**
	 * Transaction Child Controller
	 * ----------------------
	 * @author Somwang
	 */

class TransactionChildController extends BaseController {
	
	/**
	 * Transaction Child Add Product
	 * -----------------------
	 * @author Somwang
	 */
	public function addProduct() {
		
		$tran_parent_id = Route::input('transaction_parent_id');
		$TranParent = TransactionParent::find($tran_parent_id);
		
		return View::make('transaction_child/add_product')->with('status',$TranParent->transaction_status);
	}
	
	/**
	 * Transaction Edit
	 * -----------------
	 */
	public function edit() {

		$tran_child_id = Route::input('tran_child_id');
		$tran_parent_id = Route::input('tran_parent_id');
		$penalty = Route::input('penalty');
		
		$TranChild = TransactionChild::find($tran_child_id);


			# If Tran Child is Product
			if( $TranChild->product_id > 0) {
					
				return Redirect::to('transaction_child/product/edit/'.$tran_parent_id.'/'.$tran_child_id);
					
				# If Tran Child is Service
			} else {
					
				return Redirect::to('transaction_child/service/edit/'.$tran_parent_id.'/'.$tran_child_id);
			}

	}
	
	/**
	 * Transaction Child Edit Service
	 * -----------------------
	 * @author Somwang
	 */
	public function editService() {
	
		$tran_child_id = Route::input('tran_child_id');
		$tran_parent_id = Route::input('tran_parent_id');
	
		$TranChild = TransactionChild::find($tran_child_id);
	
		return View::make('transaction_child/edit_service')->with('TranChild',$TranChild);
	}
	
	/**
	 * Transaction Child Edit Service Submit
	 * -------------------------------------
	 * @author Somwang
	 */
	public function editServiceSubmit() {
	
		$tran_child_id = Input::get('tran_child_id');
		$tran_parent_id = Input::get('tran_parent_id');
		
		$tran_child = TransactionChild::find($tran_child_id);
	
		$rules = array(
				'quality'            => 'required',
		);
		
		$messages = array(
				'quality.required' => 'ກະລຸນາ ກະລຸນາໃສ່ຈຳນວນ',
		
		);

		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {
		
			$messages = $validator->messages();
		
			return Redirect::to('transaction_child/service/edit/'.Input::get('tran_parent_id').'/'.Input::get('tran_child_id'))->withErrors($validator);
		
		} else {

			$Service = Service::find($tran_child->service_id);
			
			$tran_child->quality = Input::get('quality');
			$tran_child->remark = Input::get('remark');
			$tran_child->issue_date = Tool::toMySqlDate(Input::get('issue_date'));
			$tran_child->total = Input::get('quality') * $Service->price;
			$tran_child->save();
			
			# Update Transaction Parent Total
			$sumTranChild = TransactionChild::where('transaction_parent_id','=',$tran_parent_id)->sum('total');
			
			$TranParent = TransactionParent::find($tran_parent_id);
			$TranParent->grand_total = $sumTranChild;
			$TranParent->save();
			
			# Update Invoice Amount
			TransactionInvoice::amountUpdate(Input::get('transaction_parent_id'));
			
			return Redirect::to('transaction')->with('message_child','ລາຍການ ການບໍລິການ ໄດ້ຖືກບັນທຶກແລ້ວ');
		
		}
	}
	
	public function ajaxSubmit() {
	
	    $userData = array(
	        'product_id'      => Input::get('product_id'),
	        'quality'      => Input::get('quality'),
	       //'issue_slip_id'      => Input::get('issue_slip_id'),
	        //'issued_date'      => Input::get('issued_date'),
	    );
	    $rules = array(
	        'product_id'      =>  'required',
	        'quality'      =>  'required',
	         
	       // 'issue_slip_id'      =>  'required',
	        //'issued_date'      =>  'required',
	    );
	
	     
	    $validator = Validator::make($userData, $rules);
	     
	    if($validator->fails())
	         
	        return Response::json(array(
	            'fail' => true,
	            'errors' => 'ກະລຸນາໃສ່ຂໍ້ມູນໃຫ້ຄົບ ລະຫັດສິນຄ້າ, ລະຫັດບິນໃບອອກສິນຄ້າ, ຈຳນວນ ແລະ ວັນທີ'
	        ));
	         
	        else {
	
	            $Product = Product::find(Input::get('product_id'));
	            $Price = $Product->price;
	            
	            # Total
	            $Total = $Price * Input::get('quality');
	            
	            $tranChild = new TransactionChild();
	            $tranChild->transaction_parent_id = Input::get('tran_parent_id');
	            $tranChild->quality = Input::get('quality');
	            $tranChild->product_id = Input::get('product_id');
	            $tranChild->issue_slip_id = 'BF'.Input::get('issue_slip_id');
	            $tranChild->truck_number = 'FMG-'.Input::get('truck_number');
	            $tranChild->price = $Price;
	            $tranChild->issue_date = Input::get('issued_date') ? Tool::toMySqlDateTime(Input::get('issued_date').' '.Input::get('HH').':'.Input::get('MM')) : null;
	            $tranChild->total = $Total;
	            $tranChild->save();
	            
	            # Update Transaction Parent Total
	            $sumTranChild = TransactionChild::where('transaction_parent_id','=',Input::get('tran_parent_id'))->sum('total');
	            
	            $TranParent = TransactionParent::find(Input::get('tran_parent_id'));
	            $TranParent->grand_total = $sumTranChild;
	            $TranParent->save();
	            
	            # Update Invoice Amount
	            TransactionInvoice::amountUpdate(Input::get('tran_parent_id'));
	            
	            return Response::json(array(
	                'success' => true,
	            ));
	
	        }
	         
	}
	
	/**
	 * Transaction Child Edit Product
	 * -----------------------
	 * @author Somwang
	 */
	public function editProduct() {
	
		$tran_child_id = Route::input('tran_child_id');
		$tran_parent_id = Route::input('tran_parent_id');
		
		$tran_parent = TransactionParent::find($tran_parent_id);
		$TranChild = TransactionChild::find($tran_child_id);
	
		return View::make('transaction_child/edit_product')->with('TranChild',$TranChild)->with('TranParent',$tran_parent);
	}
	
	/**
	 * Transaction Child Edit Product
	 * -----------------------
	 * @author Somwang
	 */
	public function editProductSubmit() {

		$tran_child_id = Input::get('tran_child_id');
		$tran_parent_id = Input::get('tran_parent_id');
		
		$tran_child = TransactionChild::find($tran_child_id);
		$tran_parent = TransactionParent::find($tran_parent_id);
		
		if( $tran_parent->transaction_status == 0 ) {
			
			$rules = array(
					//'issue_slip_id'            => 'required',
					//'issue_date'            => 'required',
					'quality'            => 'required',
			);
				
			
			$messages = array(
					//'issue_slip_id.required' => 'ກະລຸນາ ໃສ່ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ',
					//'issue_date.required' => 'ກະລຸນາ ເລືອກວັນທີ່ເບີກຈ່າຍສິນຄ້າ',
					'quality.required' => 'ກະລຸນາ ກະລຸນາໃສ່ຈຳນວນ',
			);
			
		} else {
			
			$rules = array(
					'issue_slip_id'            => 'required',
					'issue_date'            => 'required',
					'quality'            => 'required',
			);
			

			$messages = array(
					'issue_slip_id.required' => 'ກະລຸນາ ໃສ່ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ',
					'issue_date.required' => 'ກະລຸນາ ເລືອກວັນທີ່ເບີກຈ່າຍສິນຄ້າ',
					'quality.required' => 'ກະລຸນາ ກະລຸນາໃສ່ຈຳນວນ',
			);

		}
		

		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {
		
			$messages = $validator->messages();
		
			return Redirect::to('transaction_child/product/edit/'.Input::get('tran_parent_id').'/'.Input::get('tran_child_id'))->withErrors($validator);
		
		} else {
				
			$Product = Product::find($tran_child->product_id);
			$Price = $Product->price;
			$TransactionChild = TransactionChild::find($tran_child_id);

			# Total
			$Total = $Price * Input::get('quality');
			$TransactionChild->issue_slip_id = Input::get('issue_slip_id');
			$TransactionChild->issue_date = Input::get('issue_date') ? Tool::toMySqlDateTime(Input::get('issue_date')) : null;
			$TransactionChild->quality = Input::get('quality');
			$TransactionChild->total = Input::get('quality') * $Price;
			$TransactionChild->truck_number = Input::get('truck_number');
			$TransactionChild->remark = Input::get('remark');
			$TransactionChild->save();
			
			# Update Transaction Parent Total
			$sumTranChild = TransactionChild::where('transaction_parent_id','=',$tran_parent_id)->sum('total');

			$TranParent = TransactionParent::find($tran_parent_id);
			$TranParent->grand_total = $sumTranChild;
			$TranParent->save();
			
			# Update Invoice Amount
			TransactionInvoice::amountUpdate($tran_parent_id);

			return Redirect::to('transaction')->with('message_child','ລາຍການ ສິນຄ້າ ໄດ້ຖືກບັນທຶກແລ້ວ');
		
		}
	}
	
	/**
	 * Transaction Child Add Service
	 * -----------------------
	 * @author Somwang
	 */
	public function addService() {
	
		return View::make('transaction_child/add_service');
	}
	
	/**
	 * Get Transaction Child in Json format
	 * -------------------------------------
	 * @author Somwang
	 */
	public function transactionChildJson() {
		
		if( Route::input('invoice') == 0 ) {
			
			$TransactionParentId = Route::input('transaction_parent_id');
				
			$data = TransactionChild::getDataByParentId($TransactionParentId);

			return $data ? Response::json($data)->setCallback(Input::get('callback')) : false;
			
		}  else {

			$data = TransactionInvoicePenalty::get_invoice_penalty( Route::input('invoice') );
			
			
				
			return Response::json($data)->setCallback(Input::get('callback'));
		}

	}
	
	/**
	 * Transaction Child product add submit
	 * -------------------------------------
	 * @author Somwang
	 */
	public function addProductSubmit() {

		$tran_parent_id = Input::get('transaction_parent_id');
		$TranParent = TransactionParent::find($tran_parent_id);
		
		if( $TranParent->transaction_status == 0 ) {
			
			$rules = array(
					'product_id'            => 'required',
					//'issue_slip_id'            => 'required',
					//'issue_date'            => 'required',
					'quality'            => 'required',
					//'truck_number'            => 'required',
			);
			
			$messages = array(
					'product_id.required' => 'ກະລຸນາ ເລືອກລາຍສິນຄ້າ',
					//'issue_slip_id.required' => 'ກະລຸນາ ໃສ່ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ',
					//'issue_date.required' => 'ກະລຸນາ ເລືອກວັນທີ່ເບີກຈ່າຍສິນຄ້າ',
					'quality.required' => 'ກະລຸນາ ກະລຸນາໃສ່ຈຳນວນ',
					//'truck_number.required' => 'ກະລຸນາ ໃສ່ຫມາຍເລກທະບຽນລົດຂົນສົ່ງ',
			
			);
			
		} else {
			
			$rules = array(
					'product_id'            => 'required',
					'issue_slip_id'            => 'required',
					'issue_date'            => 'required',
					'quality'            => 'required',
					//'truck_number'            => 'required',
			);
				
			$messages = array(
					'product_id.required' => 'ກະລຸນາ ເລືອກລາຍສິນຄ້າ',
					'issue_slip_id.required' => 'ກະລຸນາ ໃສ່ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ',
					'issue_date.required' => 'ກະລຸນາ ເລືອກວັນທີ່ເບີກຈ່າຍສິນຄ້າ',
					'quality.required' => 'ກະລຸນາ ກະລຸນາໃສ່ຈຳນວນ',
					//'truck_number.required' => 'ກະລຸນາ ໃສ່ຫມາຍເລກທະບຽນລົດຂົນສົ່ງ',
						
			);
				
		}
		
		
		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails()) {

			$messages = $validator->messages();

			return Redirect::to('transaction_child/product/add/'.Input::get('transaction_parent_id'))->withErrors($validator);
		
		} else {
			
		
			$TransactionChild = new TransactionChild();
			$TransactionChild->transaction_parent_id = Input::get('transaction_parent_id');
			$TransactionChild->product_id = Input::get('product_id');
			
			# Find Price
			$Product = Product::find(Input::get('product_id'));
			$Price = $Product->price;
			
			# Total 
			$Total = $Price * Input::get('quality');
			
			$TransactionChild->issue_slip_id = Input::get('issue_slip_id');
			$TransactionChild->issue_date = Input::get('issue_date') ? Tool::toMySqlDateTime(Input::get('issue_date')) : null;
			$TransactionChild->quality = Input::get('quality');
			$TransactionChild->truck_number = Input::get('truck_number');
			$TransactionChild->remark = Input::get('remark');
			$TransactionChild->user_id = Auth::id();
			$TransactionChild->total = $Total;
			$TransactionChild->price = $Price;
			$TransactionChild->save();
			
			# Update Transaction Parent Total
			$sumTranChild = TransactionChild::where('transaction_parent_id','=',Input::get('transaction_parent_id'))->sum('total');
			
			$TranParent = TransactionParent::find(Input::get('transaction_parent_id'));
			$TranParent->grand_total = $sumTranChild;
			$TranParent->save();

			//exit();
			return Redirect::to('transaction')->with('message_child','ລາຍການ ສິນຄ້າ ໄດ້ຖືກບັນທຶກແລ້ວ');

		}
		
	}
	
	/**
	 * Transaction Child add service submit
	 * -----------------------------------
	 * @author Somwang
	 */
	public function addServiceSubmit() {

		$rules = array(
				'service_id'            => 'required',
				//'issue_slip_id'            => 'required',
				//'issue_date'            => 'required',
				'quality'            => 'required',
				//'truck_number'            => 'required',
		);
	
		$messages = array(
				'service_id.required' => 'ກະລຸນາ ເລືອກລາຍ ການບໍລິການ',
				//'issue_slip_id.required' => 'ກະລຸນາ ໃສ່ລະຫັດ ໃບເບີກຈ່າຍສິນຄ້າ',
				//'issue_date.required' => 'ກະລຸນາ ເລືອກວັນທີ່ເບີກຈ່າຍສິນຄ້າ',
				'quality.required' => 'ກະລຸນາ ກະລຸນາໃສ່ຈຳນວນ',
				//'truck_number.required' => 'ກະລຸນາ ໃສ່ຫມາຍເລກທະບຽນລົດຂົນສົ່ງ',
	
		);
	
		$validator = Validator::make(Input::all(), $rules, $messages);
	
		if ($validator->fails()) {
	
			$messages = $validator->messages();
	
			return Redirect::to('transaction_child/service/add/'.Input::get('transaction_parent_id'))->withErrors($validator);
	
		} else {
				
	
			$TransactionChild = new TransactionChild();
			$TransactionChild->transaction_parent_id = Input::get('transaction_parent_id');
			$TransactionChild->service_id = Input::get('service_id');
				
			# Find Price
			$Service = Service::find(Input::get('service_id'));
			$Price = $Service->price;
				
			# Total
			$Total = $Price * Input::get('quality');

			$TransactionChild->quality = Input::get('quality');
			$TransactionChild->issue_date = Tool::toMySqlDate(Input::get('issue_date'));
			$TransactionChild->remark = Input::get('remark');
			$TransactionChild->user_id = Auth::id();
			$TransactionChild->total = $Total;
			$TransactionChild->price = $Price;
			$TransactionChild->save();
				
			# Update Transaction Parent Total
			$sumTranChild = TransactionChild::where('transaction_parent_id','=',Input::get('transaction_parent_id'))->sum('total');
				
			$TranParent = TransactionParent::find(Input::get('transaction_parent_id'));
			$TranParent->grand_total = $sumTranChild;
			$TranParent->save();
	
			# Update Invoice Amount
			TransactionInvoice::amountUpdate(Input::get('transaction_parent_id'));
			
			return Redirect::to('transaction')->with('message_child','ລາຍການ ການບໍລິການ ໄດ້ຖືກບັນທຶກແລ້ວ');
	
		}
	
	}
	
	/**
	 * Tran Child Remove
	 * ---------------
	 */
	public function remove() {

		return View::make ( 'transaction_child/remove' );
	}
	
	/**
	 * Tran Child Remove Submit
	 * ---------------
	 */
	public function removeSubmit() {
		
		$TranChild = TransactionChild::find(Input::get('tran_child_id'));
		$TranChild->delete();
		
		# Update Transaction Parent Total
		$sumTranChild = TransactionChild::where('transaction_parent_id','=',Input::get('tran_parent_id'))->sum('total');
		$TranParent = TransactionParent::find(Input::get('tran_parent_id'));
		$TranParent->grand_total = $sumTranChild;
		$TranParent->save();
		
		# Update Invoice Amount
		TransactionInvoice::amountUpdate(Input::get('tran_parent_id'));
		
		return Redirect::to('transaction')->with('message_child','ລາຍການ  ໄດ້ຖືກລົບລ້າງແລ້ວ');
	}
	
}