<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = ['sub_task_id', 'user_id', 'time'];

    public function subtask()
    {
        return $this->belongsTo(Subtask::class, 'sub_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
