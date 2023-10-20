<?php

namespace App\Filters\Blog;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->where(function ($query) use ($value) {
            $query
                ->where('name', 'LIKE', "%{$value}%")
                ->orWhere('description', 'LIKE', "%{$value}%");
        });
    }
}
