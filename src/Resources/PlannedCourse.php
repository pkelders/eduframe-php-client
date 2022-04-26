<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;


class PlannedCourse extends Resource {
	use FindAll, FindOne, Storable;


    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'course_id',
        'course_location_id',
        'course_variant_id',
        'type',
        'start_date',
        'end_date',
        'status',
        'availability_state',
        'cost_scheme',
        'cost',
        'currency',
        'custom',
        'meetings',
        'teachers',
        'course_variant',
        'course_location',
        'available_places',
        'min_participants',
        'max_participants',
        'current_participants',
        'is_published',
        'updated_at',
        'created_at'
    ];

    /**
     * @var string
     */
    protected $model_name = 'PlannedCourse';

    /**
     * @var string
     */
    protected $endpoint = 'planned_courses';

    /**
     * @var string
     */
    protected $namespace = 'planned_course';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'meetings'    => [
            'entity' => Meeting::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'teachers'    => [
            'entity' => Teacher::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ]
    ];

    /**
     * @var array
     */
    protected $singleNestedEntities = [
        'course_variant'  => Variant::class,
        'course_location' => Location::class,
    ];
}
