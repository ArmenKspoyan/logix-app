<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\News\NewsResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Contracts\News\INewsRepository;
use App\Services\Attachment\AttachmentNewsImagesService;

class NewsController extends Controller
{
    /**
     * BlogController constructor.
     * @param INewsRepository $newsRepository
     * @param AttachmentNewsImagesService $attachmentNewsImagesService
     */
    public function __construct(
        private readonly INewsRepository             $newsRepository,
        private readonly AttachmentNewsImagesService $attachmentNewsImagesService,
    )
    {
    }

    public function index(): PaginationResource
    {
        $blogs = $this->newsRepository->getNews();
        return PaginationResource::make([
            'data' => NewsResource::collection($blogs->items()),
            'pagination' => $blogs
        ]);

    }

    public function store(StoreNewsRequest $request): SuccessResource|ErrorResource
    {
        $data = $request->validated();
        $news = $this->newsRepository->create($data);

        if (!$news) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->attachmentNewsImagesService->store($news, $data['images']);
        return SuccessResource::make([
            'message' => 'News created successfully'
        ]);


    }

    public function show(int $id): SuccessResource|ErrorResource
    {
        $blog = $this->newsRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }

        return SuccessResource::make([
            'data' => NewsResource::make($blog),
            'message' => trans('Single News')
        ]);

    }

    public function destroy(int $id): SuccessResource|ErrorResource
    {
        $blog = $this->newsRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->newsRepository->delete($id);
        return SuccessResource::make([
            'message' => trans('News deleted successfully')
        ]);
    }

    public function update(UpdateNewsRequest $request, int $id): SuccessResource|ErrorResource
    {
        $blog = $this->newsRepository->find($id);
        if (is_null($blog)) {
            return ErrorResource::make([
                'success' => false,
                'message' => trans('Something went wrong')
            ]);
        }
        $this->newsRepository->update($id, $request->validated());
        return SuccessResource::make([
            'message' => trans('News updated successfully')
        ]);
    }
}
