<?php

namespace App\Traits;

use App\Models\Image;

trait ImageTrait
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('is_main', 'DESC');
    }

    public function image()
    {
    	return $this->morphOne(Image::class, 'imageable')->where('is_main', true);
    }
}
