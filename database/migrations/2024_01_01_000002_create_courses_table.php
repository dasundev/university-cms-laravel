<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('credits');
            $table->enum('semester', ['Fall', 'Spring', 'Summer']);
            $table->integer('year');
            $table->string('instructor');
            $table->integer('capacity');
            $table->string('schedule')->nullable();
            $table->string('room')->nullable();
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};