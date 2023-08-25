<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;

class Meeting extends Resource {
	use FindAll, FindOne, Storable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
		'planned_course_id',
		'description',
		'description_dashboard',
		'meeting_location_id',
        'teachers',
		'start_date_time',
		'end_date_time',
		'updated_at',
		'created_at'
	];

    /**
     * @var string
     */
    protected $endpoint = 'meetings';

    protected $multipleNestedEntities = [

        'teachers'    => [
            'entity' => Teacher::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ]
    ];

    protected $multipleNestedEntities = [

        'teachers'    => [
            'entity' => Teacher::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ]
    ];

	/**
	 * @var string
	 */
	protected $namespace = 'meeting';
}
