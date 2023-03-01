<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Element extends Resource {
    use FindAll, FindOne;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'course_id',
        'edition_id',
        'planned_course_id',
        'position'
    ];

    /**
     * @var string
     */
    protected $model_name = 'Element';

    /**
     * @var string
     */
    protected $endpoint = 'program/elements';

    /**
     * @var string
     */
    protected $namespace = 'element';
}
