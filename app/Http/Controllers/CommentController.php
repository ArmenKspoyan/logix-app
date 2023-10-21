<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\BlogComment\IBlogCommentRepository;
use App\Repositories\Contracts\Comment\ICommentRepository;
use App\Repositories\Contracts\UserComment\IUserCommentRepository;

class CommentController extends Controller
{

    /**
     * BlogController constructor.
     * @param ICommentRepository $commentRepository
     * @param IBlogCommentRepository $blogCommentRepository
     * @param IUserCommentRepository $userCommentRepository
     */
    public function __construct(
        private readonly ICommentRepository     $commentRepository,
        private readonly IBlogCommentRepository $blogCommentRepository,
        private readonly IUserCommentRepository $userCommentRepository,
    )
    {
    }

    public function store(StoreCommentRequest $request): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $comment = $this->commentRepository->create(['text' => $data['text']]);
        if (!$comment) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->blogCommentRepository->create(['comment_id' => $comment['id'], 'blog_id' => $data['id']]);
        $this->userCommentRepository->create(['comment_id' => $comment['id'], 'user_id' => auth()->user()->id]);
        return SuccessResource::make([
            'message' => 'Comment created successfully'
        ]);
    }

    public function update(UpdateCommentRequest $request, int $id): SuccessResource
    {
        $data = $request->validated();
        $this->commentRepository->update($id, ['text' => $data['text']]);
        return SuccessResource::make([
            'message' => 'Comment updated successfully'
        ]);
    }

    public function delete(int $id): SuccessResource|ErrorResource
    {
        $blog = $this->commentRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->commentRepository->delete($id);
        return SuccessResource::make([
            'message' => trans('Comment deleted successfully')
        ]);
    }
}
