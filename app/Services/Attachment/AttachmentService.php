<?php

namespace App\Services\Attachment;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{

    public function store($attachment): void
    {
        if ($attachment) {
            $filename = (time() + rand(1, 10000)) . '_' . $attachment->getClientOriginalName();
            $path = 'image/' . auth()->user()->id . '/' . $filename;
            Storage::put($path, File::get((string)$attachment));
        }
    }
}
