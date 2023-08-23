<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Removable;
use Eduframe\Traits\Storable;

class Attendance extends Resource {
    use FindAll, Storable;
    protected $fillable = [
        'id',
        'meeting_id',
        'enrollment_id',
        'state',
        'comment',
        'updated_at',
        'created_at'
        ];
	/**
     * @var string
     */
	protected $model_name = 'Attendance';

	/**
     * @var string
     */
	protected $endpoint = 'attendances';

	/**
     * @var string
     */
	protected $namespace = 'attendance';

}