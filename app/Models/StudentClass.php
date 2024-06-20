<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(StudyDirection::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
