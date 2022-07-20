<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class CatalogVariant extends Resource {
    use FindAll, FindOne;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'product_id',
        'variantable_type',
        'variantable_id',
        'is_published',
        'cost_scheme',
        'cost',
        'availability',
        'updated_at',
        'created_at',
        'available_places',
        'currency'
    ];

    /**
     * @var string
     */
    protected $model_name = 'CatalogVariant';

    /**
     * @var string
     */
    protected $endpoint = 'catalog/variants';

    /**
     * @var string
     */
    protected $namespace = 'catalog_variant';
}
