<?php

use App\Models\StudyDirection;
use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StudyDirection::class)->constrained();
            $table->foreignIdFor(Teacher::class)->constrained();
            $table->string('academic_year', 10);
            $table->string('name', 10);
            $table->unsignedTinyInteger('student_count')->default(0);
            $table->string('comments', 200)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_classes');
    }
};
