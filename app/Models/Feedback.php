<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    use HasFactory;
    protected $fillable = [ 'video_id', 'comment', 'rating', 'r1', 'r2', 'r3'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
