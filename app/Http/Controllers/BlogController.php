<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PaginationResource;
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

    public function index(): PaginationResource
    {
        $blogs = $this->blogRepository->getBlogs();
        return PaginationResource::make([
            'data' => BlogResource::collection($blogs->items()),
            'pagination' => $blogs
        ]);

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

    public function show(int $id): SuccessResource|ErrorResource
    {
        $blog = $this->blogRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }

        return SuccessResource::make([
            'data' => BlogResource::make($blog),
            'message' => trans('Single Blog')
        ]);

    }

    public function destroy(int $id): SuccessResource|ErrorResource
    {
        $blog = $this->blogRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->blogRepository->delete($id);
        return SuccessResource::make([
            'message' => trans('Blog deleted successfully')
        ]);

    }

    public function update(UpdateBlogRequest $request, int $id): SuccessResource|ErrorResource
    {
        $blog = $this->blogRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->blogRepository->update($id, $request->validated());
        return SuccessResource::make([
            'message' => trans('Blog updated successfully')
        ]);
    }
}
