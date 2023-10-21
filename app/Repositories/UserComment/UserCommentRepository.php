<?php

namespace App\Repositories\UserComment;

use App\Models\UserComment;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UserComment\IUserCommentRepository;

class UserCommentRepository extends BaseRepository implements IUserCommentRepository
{
    public function __construct(UserComment $model)
    {
        parent::__construct($model);
    }

}
