<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Category extends Resource {
	use FindAll, FindOne;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'name',
		'slug',
		'position',
		'description',
		'avatar',
		'meta_title',
		'meta_description',
		'parent_id',
		'is_published',
		'updated_at',
		'created_at'
	];

	/**
	 * @var string
	 */
	protected $model_name = 'Category';

	/**
	 * @var string
	 */
	protected $endpoint = 'categories';

	/**
	 * @var string
	 */
	protected $namespace = 'category';
}
