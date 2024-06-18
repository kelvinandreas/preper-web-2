<?php

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
        Schema::create('trmentoringschedule', function (Blueprint $table) {
            $table->string('TrMentoringScheduleId', 191)->primary();
            $table->string('MenteeUserId', 191)->nullable();
            $table->string('MentorUserId', 191)->nullable();
            $table->string('UniqueCode', 191)->unique();
            $table->string('MeetingTime', 191);
            $table->string('MeetingLink', 191)->nullable();
            $table->string('MenteeReview', 191)->nullable();
            $table->string('SubjectId');
            $table->string('SpecificTopic', 191)->nullable();
            $table->boolean('IsDone')->default(false);
            $table->timestamps();

            $table->foreign('SubjectId')->references('SubjectId')->on('mssubject')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('MenteeUserId')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('MentorUserId')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trmentoringschedule');
    }
};
