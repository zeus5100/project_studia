<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

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
