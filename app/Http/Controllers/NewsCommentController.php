<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsComment\StoreNewsCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\Comment\ICommentRepository;
use App\Repositories\Contracts\NewsComment\INewsCommentRepository;
use App\Repositories\Contracts\UserComment\IUserCommentRepository;

class NewsCommentController extends Controller
{
    /**
     * BlogController constructor.
     * @param ICommentRepository $commentRepository
     * @param INewsCommentRepository $newsCommentRepository
     * @param IUserCommentRepository $userCommentRepository
     */
    public function __construct(
        private readonly ICommentRepository     $commentRepository,
        private readonly INewsCommentRepository $newsCommentRepository,
        private readonly IUserCommentRepository $userCommentRepository,
    )
    {
    }

    public function index(): PaginationResource
    {
        $comments = $this->commentRepository->getCommentsByNews();
        return PaginationResource::make([
            'data' => CommentResource::collection($comments->items()),
            'pagination' => $comments
        ]);
    }

    public function store(StoreNewsCommentRequest $request): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $comment = $this->commentRepository->create([
            'text' => $data['text'],
            'blog_id' => null,
            'news_id' => $data['id'],
        ]);
        if (!$comment) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->newsCommentRepository->create(['comment_id' => $comment['id'], 'news_id' => $data['id']]);
        $this->userCommentRepository->create(['comment_id' => $comment['id'], 'user_id' => auth()->user()->id]);
        return SuccessResource::make([
            'message' => 'Comment created successfully'
        ]);
    }
}
