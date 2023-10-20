<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\Comment\ICommentRepository;
use App\Services\Comment\CommentService;

class CommentController extends Controller
{

    /**
     * BlogController constructor.
     * @param ICommentRepository $commentRepository
     * @param CommentService $commentService
     */
    public function __construct(
        private readonly ICommentRepository $commentRepository,
        private readonly CommentService     $commentService,
    )
    {
    }

    public function createComment(StoreCommentRequest $request): SuccessResource|ErrorResource
    {
        $comment = $this->commentService->createComment($request->validated());
        if (!$comment) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        return SuccessResource::make([
            'message' => 'Comment created successfully'
        ]);
    }

    public function updateComment(UpdateCommentRequest $request): SuccessResource
    {
        $data = $request->validated();
        $this->commentRepository->update($data['id'], ['text' => $data['text']]);
        return SuccessResource::make([
            'message' => 'Comment updated successfully'
        ]);
    }

    public function deleteComment(int $id): SuccessResource|ErrorResource
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
