<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Services\Attachment\AttachmentBlogImagesService;

class BlogController extends Controller
{

    /**
     * AuthController constructor.
     * @param IBlogRepository $blogRepository
     * @param AttachmentBlogImagesService $attachmentBlogImagesService
     */
    public function __construct(
        private readonly IBlogRepository             $blogRepository,
        private readonly AttachmentBlogImagesService $attachmentBlogImagesService,
    )
    {
    }

    public function index()
    {

    }

    public function store(StoreBlogRequest $request): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $blog = $this->blogRepository->create($data);

        if (!$blog) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->attachmentBlogImagesService->store($blog, $data['images']);
        return SuccessResource::make([
            'message' => 'Blog created successfully'
        ]);


    }

    public function show()
    {

    }

    public function destroy()
    {

    }

    public function update()
    {
    }
}
