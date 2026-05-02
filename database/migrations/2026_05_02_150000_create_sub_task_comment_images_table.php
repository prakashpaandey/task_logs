<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_task_comment_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_task_comment_id')->constrained('sub_task_comments')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_task_comment_images');
    }
};
