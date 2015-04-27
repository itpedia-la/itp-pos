<?php
/**
 * Product Controller
 * ------------------
 * @author Theppany
 */

use Boris\Config;
class ProductController extends BaseController {
	
	/**
	 * Product Index
	 * -------------
	 * @author Theppany
	 */
	public function index() {

		return View::make ( 'product.index' );
	}
	
	/**
	 * Product List JSONP
	 * ---------------
	 * @author Theppany
	 */
	public function product_list_json() {
		
		$data = Product::where ( 'id','>', 0 )->get ()->toArray ();
		
		# Rebuild Array to convert created_at, updated_at to standard format
		foreach($data as $key=> $value) {
			
			$data[$key]['title_html'] = $value['title'].' / '.$value['price'].' '.strtoupper($value['currency']).' ('.$value['unit'].')';
			$data[$key]['prict_html'] = $value['price'].' '.strtoupper($value['currency']).' ('.$value['unit'].')';
			$data[$key]['created_at'] = Tool::toDateTime($value['created_at']);
			$data[$key]['updated_at'] = Tool::toDateTime($value['updated_at']);
		}
		
		return Response::json ( $data )->setCallback ( Input::get ( 'callback' ) );
	}
	

	/**
	 * Product Remove
	 * ---------------
	 * @author Theppany
	 */
	public function remove($id) {
		$product = Product::find ( $id );
		return View::make ( 'product.remove' )->with ( 'product', $product );
	}

	/**
	 * Product Add
	 * -----------
	 * @author Theppany
	 */
	public function add() {
		
		return View::make ( 'product/form' );
	}
	
	/**
	 * Product Edit
	 * -----------
	 * @author Somwang
	 */
	public function edit() {
	
		$data = Product::find(Route::input('product_id'));

		return View::make ( 'product/form' )->with('data', @$data);

	}
	
	
	/**
	 * Product Form Submit
	 * -------------------
	 * @author Somwang
	 */
	public function formSubmit() {
		
		$product_id = Input::get('product_id');
		
		$rules = array (
				'title' => 'required',
				'unit' => 'required', 
				'sand_kg' => 'required',
				'crashed_stone_kg' => 'required',
				'water_litre' => 'required',
				'admixture_1_cc' => 'required',
				'price' => 'required',
		
		);
		
		$messages = array (
				'title.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຊື່ສິນຄ້າ',
				'unit.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຫົວໜ່ວຍ', 
				'sand_kg.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຊາຍ (kg)',
				'crashed_stone_kg.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ຫິນຂົບ (kg)',
				'water_litre.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ນຳ້ (litre)',
				'admixture_1_cc.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ສ່ວນປະສົມ ນຳ້ຢາ (cc)',
				'price.required' => 'ກະລຸນາປ້ອນຂໍ້ມູນ ລາຄາ',
		);
		
		$validator = Validator::make ( Input::all (), $rules, $messages );
		
		if ($validator->fails ()) {
				
			// get the error messages from the validator
			$messages = $validator->messages ();
				
			// redirect our cust back to the form with the errors from the validator
			return Redirect::to ( $product_id > 0 ? 'product/edit/'.$product_id : 'product/add' )->withErrors ( $validator )->with ( 'data', Input::all () );
			
		} else {
			
			$product = $product_id > 0 ? Product::find($product_id) : new Product();
			$product->title = Input::get ( 'title' );
			$product->unit = Input::get ( 'unit' );
			$product->cement_1_kg = Input::get ( 'cement_1_kg' );
			$product->cement_2_kg = Input::get ( 'cement_2_kg' );
			$product->cement_3_kg = Input::get ( 'cement_3_kg' );
			$product->cement_4_kg = Input::get ( 'cement_4_kg' );
			$product->cement_5_kg = Input::get ( 'cement_5_kg' );
			$product->cement_6_kg = Input::get ( 'cement_6_kg' );
			$product->sand_kg = Input::get ( 'sand_kg' );
			$product->crashed_stone_kg = Input::get ( 'crashed_stone_kg' );
			$product->water_litre = Input::get ( 'water_litre' );
			$product->admixture_1_cc = Input::get ( 'admixture_1_cc' );
			$product->admixture_2_cc = Input::get ( 'admixture_2_cc' );
			$product->admixture_3_cc = Input::get ( 'admixture_3_cc' );
			$product->price = Input::get ( 'price' );
			$product->currency = 'thb';
			$product->remark_note = Input::get ( 'remark_note' );
			$product->save ();
			return Redirect::to ( 'product' )->with ( 'message', 'ຂໍ້ມູນສິນຄ້າໄດ້ຖືກບັນທຶກແລ້ວ' );
		}
	}
	
	
	/**
	 * Product Delete
	 * ---------------
	 * @author Theppany
	 */
	public function delete() {
		$product_id = Input::get('product_id');
		$product = Product::find($product_id);
		$product->delete();
	
		return Redirect::to ( 'product' )->with ( 'message', 'ລຶບຂໍ້ມູນສິນຄ້າສຳເລັດ' );
	}
	
}
