<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Resources\Credits\Definition;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;

class Course extends Resource {
	use FindAll, FindOne, Storable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'category_id',
		'slug',
		'name',
		'position',
		'meta_title',
		'meta_description',
		'code',
        'cost',
        'cost_scheme',
		'duration',
		'starting_price',
		'signup_url',
		'slug_history',
		'avatar',
		'level',
		'result',
		'conditions_or_default',
		'course_tab_contents',
		'credit_definitions',
		'labels',
		'is_published',
		'custom',
		'updated_at',
		'created_at'
	];


    /**
     * @var string
     */
    protected $model_name = 'Course';

    /**
     * @var string
     */
    protected $endpoint = 'courses';

    /**
     * @var string
     */
    protected $namespace = 'course';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'course_tab_contents' => [
            'entity' => CourseTabContent::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'credit_definitions' => [
            'entity' => Definition::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'labels' => [
            'entity' => Label::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
