<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperTaskComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_task_id',
        'user_id',
        'comment',
    ];

    /**
     * Get the task that the comment belongs to.
     */
    public function task()
    {
        return $this->belongsTo(DeveloperTask::class, 'developer_task_id');
    }

    /**
     * Get the user who made the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
