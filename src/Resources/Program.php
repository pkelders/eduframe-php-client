<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Program extends Resource {
	use FindAll, FindOne;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'category_id',
		'name',
		'slug',
		'cost',
		'conditions',
		'is_published',
		'course_tab_contents',
		'labels',
		'custom',
		'signup_url',
		'updated_at',
		'created_at'
	];

	/**
	 * @var string
	 */
	protected $model_name = 'Program';

	/**
	 * @var string
	 */
	protected $endpoint = 'program/programs';

	/**
	 * @var string
	 */
	protected $namespace = 'program';

	/**
	 * @var array
	 */
	protected $multipleNestedEntities = [
		'course_tab_contents' => [
			'entity' => CourseTabContent::class,
			'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
		],
		'labels' => [
			'entity' => Label::class,
			'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
		],
	];
}
