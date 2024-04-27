<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
   
   // protected $appends = ['replays'];
   protected $appends = ['image_url'];

    protected $fillable = [
        'content',
        'commentable_id',
        'commentable_type',
        'user_id',
        'image_id',
    ];
     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'image_id',
        'image',
    ];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'commentable_id')->where('commentable_type', 'App\Models\Comment');
    }
    public function commentable()
    {
        return $this->morphTo();
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
