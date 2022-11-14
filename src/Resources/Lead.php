<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;

class Lead extends Resource {
	use FindAll, FindOne, Storable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'title',
		'company_name',
		'first_name',
		'middle_name',
		'last_name',
		'administrator_id',
		'email',
		'phone',
		'status',
		'quality',
		'wants_newsletter',
		'comment',
		'website_url',
		'course_ids',
		'label_ids',
		'address',
		'labels',
		'courses_leads',
		'updated_at',
		'created_at'
	];

	/**
	 * @var string
	 */
	protected $endpoint = 'leads';

	/**
	 * @var string
	 */
	protected $namespace = 'lead';

	/**
	 * @var array
	 */
	protected $singleNestedEntities = [
		'address' => Address::class,
	];

	/**
	 * @var array
	 */
	protected $multipleNestedEntities = [
		'labels' => [
			'entity' => Label::class,
			'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
		],
		'courses_leads' => [
			'entity' => LeadInterest::class,
			'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
		],
	];
}
