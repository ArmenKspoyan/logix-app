<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\Comment\ICommentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository extends BaseRepository implements ICommentRepository
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getCommentsByBlog(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model)
            ->select('comments.*')
            ->with(['users'])
            ->whereNotNull('blog_id')
            ->whereNull('news_id')
            ->paginate(request()->query("per_page", 10));
    }

    public function getCommentsByNews(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model)
            ->select('comments.*')
            ->with(['users'])
            ->whereNotNull('news_id')
            ->whereNull('blog_id')
            ->paginate(request()->query("per_page", 10));
    }

}
