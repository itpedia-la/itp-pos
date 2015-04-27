<?php 

class TransactionInvoicePenaltyController extends BaseController {
	
	public function remove() {
	
		return View::make('invoice_penalty/remove');
		
	}
	
	public function remove_submit() {
		
		$id = Input::get('id');

		$penalty = TransactionInvoicePenalty::find($id)->delete();
		
		return Redirect::to('transaction')->with('message','ຂໍ້ມູນໄດ້ຖືກຍົກເລີກແລ້ວ');

	}
}