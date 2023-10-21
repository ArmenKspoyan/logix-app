<?php

namespace App\Repositories\NewsComment;

use App\Models\NewsComment;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\NewsComment\INewsCommentRepository;

class NewsCommentRepository extends BaseRepository implements INewsCommentRepository
{
    public function __construct(NewsComment $model)
    {
        parent::__construct($model);
    }

}
