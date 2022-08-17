<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Edition extends Resource {
	use FindAll, FindOne;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'program_id',
		'name',
		'slug',
		'cost',
		'custom',
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
	protected $model_name = 'Edition';

	/**
	 * @var string
	 */
	protected $endpoint = 'program/editions';

	/**
	 * @var string
	 */
	protected $namespace = 'edition';
}
