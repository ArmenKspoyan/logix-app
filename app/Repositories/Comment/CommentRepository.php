<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\Comment\ICommentRepository;

class CommentRepository extends BaseRepository implements ICommentRepository
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

}
