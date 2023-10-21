<?php

namespace App\Repositories\UserComment;

use App\Models\CommentUser;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UserComment\IUserCommentRepository;

class UserCommentRepository extends BaseRepository implements IUserCommentRepository
{
    public function __construct(CommentUser $model)
    {
        parent::__construct($model);
    }

}
