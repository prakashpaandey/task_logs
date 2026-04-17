<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('developer_task_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('developer_task_id')->constrained('developer_tasks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate assignments
            $table->unique(['developer_task_id', 'user_id']);
        });

        // Migrate existing data from developer_tasks to the pivot table
        $existingTasks = DB::table('developer_tasks')->select('id', 'user_id', 'created_at', 'updated_at')->get();
        foreach ($existingTasks as $task) {
            DB::table('developer_task_user')->insert([
                'developer_task_id' => $task->id,
                'user_id' => $task->user_id,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developer_task_user');
    }
};
