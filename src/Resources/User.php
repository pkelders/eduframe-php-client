<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class User extends Resource
{
    use FindAll, FindOne;

    protected $fillable = [
            'id',
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'slug',
            'avatar_url',
            'roles',
            'notes_user',
            'description',
            'employee_number',
            'student_number',
            'teacher_headline',
            'teacher_description',
            'teacher_enrollments_count',
            'locale',
            'wants_newsletter',
            'updated_at',
            'created_at',
            'address',
            'custom'
    ];

    /**
     * @var string
     */
    protected $model_name = 'Users';

    protected $endpoint = 'users';

    /**
     * @var string
     */
    protected $namespace = 'user';

    /**
     * @var array
     */
    protected $singleNestedEntities = [
        'address' => Address::class
    ];

}