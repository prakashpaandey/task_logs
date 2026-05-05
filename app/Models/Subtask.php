<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $fillable = ['main_task_id', 'title', 'description', 'work_date', 'time_logged', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mainTask()
    {
        return $this->belongsTo(MainTask::class);
    }

    public function comments()
    {
        return $this->hasMany(SubTaskComment::class, 'sub_task_id');
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class, 'sub_task_id');
    }

    protected $appends = ['total_time_logged'];

    public function getTotalTimeLoggedAttribute()
    {
        return $this->timeLogs()->sum('time');
    }

    public function syncTimeLogged()
    {
        $this->time_logged = $this->getTotalTimeLoggedAttribute();
        $this->save();
        return $this->time_logged;
    }
}
