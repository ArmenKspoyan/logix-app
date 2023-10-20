<?php

namespace App\Services\Comment;


use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Comment\ICommentRepository;
use App\Repositories\Contracts\News\INewsRepository;

class CommentService
{

    /**
     * @param ICommentRepository $commentRepository
     * @param IBlogRepository $blogRepository
     * @param INewsRepository $newsRepository
     */
    public function __construct(
        private readonly ICommentRepository $commentRepository,
        private readonly IBlogRepository    $blogRepository,
        private readonly INewsRepository    $newsRepository,
    )
    {
    }


    public function createComment(array $attributes)
    {
        $blog = null;
        $news = null;

        if ($attributes['is_blog']) {
            $blog = $this->blogRepository->find($attributes['id']);
        }
        if ($attributes['is_news']) {
            $news = $this->newsRepository->find($attributes['id']);
        }

        if ($blog || $news) {
            return $this->commentRepository->create(
                [
                    'user_id' => auth()->user()->id,
                    'text' => $attributes['text'],
                    'blog_id' => $attributes['is_blog'] ? $attributes['id'] : null,
                    'news_id' => $attributes['is_news'] ? $attributes['id'] : null,
                ]
            );
        }

        return null;

    }


}
