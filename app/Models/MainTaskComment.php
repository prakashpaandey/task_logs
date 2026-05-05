<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainTaskComment extends Model
{
    protected $fillable = ['main_task_id', 'user_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mainTask()
    {
        return $this->belongsTo(MainTask::class);
    }
}
