<?php

namespace App\Repositories\BlogComment;

use App\Models\BlogComment;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BlogComment\IBlogCommentRepository;

class BlogCommentRepository extends BaseRepository implements IBlogCommentRepository
{
    public function __construct(BlogComment $model)
    {
        parent::__construct($model);
    }

}
