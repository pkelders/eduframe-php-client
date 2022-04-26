<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class CourseTabContent extends Resource {

	/**
	 * @var array
	 */
	protected $fillable = [
        'id',
        'course_tab_id',
		'content',
		'course_tab'
	];

	/**
	 * @var string
	 */
	protected $model_name = 'CourseTabContent';

	/**
	 * @var string
	 */
	protected $endpoint = 'course_tab_contents';

	/**
	 * @var string
	 */
	protected $namespace = 'course_tab_content';

	/**
	 * @var array
	 */
	protected $singleNestedEntities = [
		'course_tab' => CourseTab::class,
	];
}
