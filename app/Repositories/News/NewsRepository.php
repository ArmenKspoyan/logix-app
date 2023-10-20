<?php

namespace App\Repositories\News;

use App\Filters\Blog\SearchFilter;
use App\Models\News;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\News\INewsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class NewsRepository extends BaseRepository implements INewsRepository
{
    public function __construct(News $model)
    {
        parent::__construct($model);
    }

    public function getNews(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model)
            ->select('news.*')
            ->with(['images'])
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter),
            ])
            ->paginate(request()->query("per_page", 10));
    }

}
