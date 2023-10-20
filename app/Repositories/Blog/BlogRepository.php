<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\Blog\IBlogRepository;

class BlogRepository extends BaseRepository implements IBlogRepository
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

}
