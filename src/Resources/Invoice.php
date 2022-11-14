<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Invoice extends Resource {
	use FindAll, FindOne;

	/**
	 * @var array
     *
	 */
	protected $fillable = [
		'id',
        'reference_id',
		'number',
        'number_int',
		'status',
        'order_number',
        'expiration_date',
        'opened_at',
        'account_id',
        'invoice_set_id',
        'feature',
        'footnote',
        'description',
        'currency',
        'total_incl',
        'total_excl',
        'total_open',
        'account_name',
        'invoice_items',

        'pdf_url',
        'xml_url',


		'updated_at',
		'created_at'
	];

	/**
	 * @var string
	 */
	protected $endpoint = 'invoices';

	/**
	 * @var string
	 */
	protected $namespace = 'invoice';

	/**
	 * @var array
	 */
	protected $multipleNestedEntities = [
		'invoice_items' => [
			'entity' => InvoiceItem::class,
			'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
		]
	];
}
