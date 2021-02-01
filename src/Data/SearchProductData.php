<?php

namespace App\Data;

use App\Entity\Product;
use App\Entity\Category;

class SearchProductData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $category = [];
}
