<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class OrderItem extends Resource {

	/**
	 * @var array
	 */
	protected $fillable = [
		'student_id',
	];

	/**
	 * @var string
	 */
	protected $endpoint = 'order_items';

	/**
	 * @var string
	 */
	protected $namespace = 'order_items';
}
