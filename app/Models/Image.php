<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    public function imageable()
    {
        return $this->morphTo();
    }
    public function getUrlAttribute()
    {
        // Assuming your images are stored in the 'storage/app/public' directory
        // You need to configure a symbolic link to the 'public/storage' directory
        // using the 'php artisan storage:link' command to make them accessible from the web
        return Storage::url($this->filename);
    }
}
