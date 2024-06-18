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
            $table->string('MentoringSession', 191);
            $table->string('MenteeUserId', 191)->nullable();
            $table->string('MentorUserId', 191)->nullable();
            $table->string('UniqueCode', 191)->unique();
            $table->timestamps();

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
