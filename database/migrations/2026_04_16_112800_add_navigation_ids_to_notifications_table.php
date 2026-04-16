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
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('type');
            $table->unsignedBigInteger('main_task_id')->nullable()->after('client_id');
            $table->unsignedBigInteger('sub_task_id')->nullable()->after('main_task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['client_id', 'main_task_id', 'sub_task_id']);
        });
    }
};
