<?php

namespace App\Services\Comment;


use App\Repositories\Contracts\Comment\ICommentRepository;

class CommentService
{

    /**
     * @param ICommentRepository $blogCommentRepository
     */
    public function __construct(
        private readonly ICommentRepository $blogCommentRepository
    )
    {
    }


}
