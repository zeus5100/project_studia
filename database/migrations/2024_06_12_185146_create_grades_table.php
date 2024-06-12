<?php

use App\Models\Activity;
use App\Models\Student;
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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Activity::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Student::class)->constrained()->onDelete('cascade');
            $table->date('grade_date');
            $table->decimal('grade_value', 3, 2);
            $table->unsignedTinyInteger('grade_weight');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
