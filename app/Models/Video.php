<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'video_type',
        'resolution',
        'video',
        'enhanced_video',
        'slug',
        'trending',
        'status',
        'user_id',
        'category_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function comments()
    {
        return $this->hasMany(Feedback::class, 'video_id', 'id');
    }
}
