<?php

/**
 * Dashboard Controller
 * -------------------
 * @author Somwang
 *
 */
class DashboardController extends BaseController {

	
	/**
	 * Dashboard Home
	 * --------------
	 * @author Somwang Souksavatd
	 */
	public function dashboard()
	{
		return View::make('dashboard/index');
	}

}
