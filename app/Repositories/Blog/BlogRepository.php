<?php

namespace App\Repositories\Blog;

use App\Filters\Blog\SearchFilter;
use App\Models\Blog;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\Blog\IBlogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BlogRepository extends BaseRepository implements IBlogRepository
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getBlogs(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model)
            ->select('blogs.*')
            ->with(['images'])
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter),
            ])
            ->paginate(request()->query("per_page", 10));
    }


}
