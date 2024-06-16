<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'academic_year',
        'name',
        'student_count',
        'comments',
        'study_direction_id',
        'teacher_id',
    ];

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function direction(): HasOne
    {
        return $this->hasOne(StudyDirection::class, 'id', 'study_direction_id');
    }
}
