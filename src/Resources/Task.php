<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Task extends Resource {
	use FindAll, FindOne;
	
	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
        'description',
        'due_date',
        'updated_at',
		'created_at',
        'starred',
        'completed_at',
        'assignee_id',
        'creator_id',
        'completed_by_id',
        'subject_type',
        'subject_id',
        'assigned_by_id'
	];

	/**
	 * @var string
	 */
	protected $model_name = 'Task';

	/**
	 * @var string
	 */
	protected $endpoint = 'tasks';

	/**
	 * @var string
	 */
	protected $namespace = 'task';
}
