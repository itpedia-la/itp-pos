<?php

/**
 * UNit Model
 * -------------------
 * @author Theppany 
 *
 */

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Product extends Eloquent {
	
	use SoftDeletingTrait;

	protected $table = 'product';

}
