<?php

namespace App\Models;

use TrueReviewer\Reviewer\Models\Contracts\ReviewableContract;
use Lunar\Models\Product as LunarProduct;
use TrueReviewer\Reviewer\Models\Concerns\Reviewable;

class Product extends LunarProduct implements ReviewableContract
{
    use Reviewable;

    public function subRatingTypes(): array
    {
        return [
            'quality' => ['title' => 'Quality'],
            'value' => ['title' => 'Value for money'],
            'durability' => ['title' => 'Durability'],
        ];
    }
}
