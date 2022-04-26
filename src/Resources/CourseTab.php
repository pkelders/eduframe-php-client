<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class CourseTab extends Resource
{

	/**
	 * @var array
	 */
	protected $fillable = [
        'id',
		'name',
		'position'
        ];


    /**
     * @var string
     */
    protected $model_name = 'CourseTab';

    /**
     * @var string
     */
    protected $endpoint = 'course_tabs';

    /**
     * @var string
     */
    protected $namespace = 'course_tab';

    /**
     * @var array
     */
    protected $singleNestedEntities = [
        'course_tab' => CourseTab::class,
    ];
}
