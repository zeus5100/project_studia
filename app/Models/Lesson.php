<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'lesson_topic',
        'lesson_datetime',
        'comments',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
