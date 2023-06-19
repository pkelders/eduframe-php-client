<?php
namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;

class Invoice extends Resource
{
    use FindAll, FindOne, Storable;
    protected $fillable = [
        ''


    ];
}
