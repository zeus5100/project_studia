<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year',
        'name',
        'student_count',
        'comments',
        'study_direction_id',
        'teacher_id',
    ];
}
