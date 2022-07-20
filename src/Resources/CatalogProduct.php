<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class CatalogProduct extends Resource {
    use FindAll, FindOne;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
		'slug',
        'category_id',
        'productable_type',
        'productable_id',
        'is_published',
        'cost_scheme',
        'cost',
        'position',
        'avatar',
        'conditions_or_default',
        'currency',
        'course_tab_contents',
        'custom',
        'labels',
        'updated_at',
        'created_at'
    ];

    /**
     * @var string
     */
    protected $model_name = 'CatalogProduct';

    /**
     * @var string
     */
    protected $endpoint = 'catalog/products';

    /**
     * @var string
     */
    protected $namespace = 'catalog_product';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'course_tab_contents' => [
            'entity' => CourseTabContent::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'labels' => [
            'entity' => Label::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
