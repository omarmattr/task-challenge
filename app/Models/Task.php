<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content',
        'image_id',
    ];
    protected $appends = ['image_url'];
    protected $hidden = [
        'image_id',
        'image',
    ];
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? $this->image->url : null;
    }
}
