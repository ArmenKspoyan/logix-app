<?php


namespace App\Repositories\Contracts\Comment;

interface ICommentRepository
{

    public function getCommentsByBlog();
    public function getCommentsByNews();
}
