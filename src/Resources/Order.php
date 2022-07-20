<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Order extends Resource {
	use FindAll, FindOne;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'number',
		'status',
		'account_id',
		'creator_id',
		'catalog_variant_id',
		'start_date',
		'end_date',
		'number_of_students',
		'order_items',
		'updated_at',
		'created_at'
	];

	/**
	 * @var string
	 */
	protected $endpoint = 'orders';

	/**
	 * @var string
	 */
	protected $namespace = 'order';

	/**
	 * @var array
	 */
	protected $multipleNestedEntities = [
		'order_items' => [
			'entity' => OrderItem::class,
			'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
		]
	];
}
