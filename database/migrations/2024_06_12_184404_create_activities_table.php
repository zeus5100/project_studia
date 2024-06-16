<?php

use App\Models\Room;
use App\Models\StudentClass;
use App\Models\Subject;
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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StudentClass::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Subject::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Room::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Teacher::class)->constrained()->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('day_of_week');
            $table->text('comments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
