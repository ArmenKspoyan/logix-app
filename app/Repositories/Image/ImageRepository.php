<?php

namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\Image\IImageRepository;

class ImageRepository extends BaseRepository implements IImageRepository
{
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

}
