<?php

namespace App\Services\Attachment;

use App\Repositories\Contracts\Image\IImageRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentBlogImagesService
{

    public function __construct(
        private readonly IImageRepository $imageRepository,
    )
    {
    }

    public function store(object $blog, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            $filename = (time() + rand(1, 10000)) . '_' . $attachment->getClientOriginalName();
            $path = 'blog' . '/' . $blog->id . '/' . $filename;
            Storage::put($path, File::get($attachment));
            $this->imageRepository->create([
                'blog_id' => $blog->id,
                'news_id' => null,
                'image' => $path
            ]);
        }
    }
}
