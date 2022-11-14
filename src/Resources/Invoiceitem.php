<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class InvoiceItem extends Resource {

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
        'name',
        'units',
        'units_price',
        'invoice_vat_id',
        'catalog_variant_id',
        'updated_at',
        'created_at',
	];

	/**
	 * @var string
	 */
	protected $endpoint = 'invoice_items';

	/**
	 * @var string
	 */
	protected $namespace = 'invoice_items';
}
