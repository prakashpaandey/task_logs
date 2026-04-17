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
        Schema::create('developer_task_comments', function (Blueprint $req) {
            $req->id();
            $req->foreignId('developer_task_id')->constrained('developer_tasks')->onDelete('cascade');
            $req->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $req->text('comment');
            $req->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_task_comments');
    }
};
