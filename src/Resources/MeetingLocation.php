<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;

class MeetingLocation extends Resource {
    use FindAll, FindOne, Storable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'course_location_id',
        'name',
        'capacity',
        'updated_at',
        'created_at',

    ];
    /**
     * @var string
     */
    protected $endpoint = 'meeting_locations';

    /**
     * @var string
     */
    protected $namespace = 'meeting_location';
}
