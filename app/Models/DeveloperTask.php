<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'priority',
        'deadline',
        'status',
        'completed_at',
    ];

    /**
     * Get the developers assigned to the task.
     */
    public function developers()
    {
        return $this->belongsToMany(User::class, 'developer_task_user', 'developer_task_id', 'user_id')->withTimestamps();
    }

    /**
     * Get the admin who assigned the task.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the comments for the developer task.
     */
    public function comments()
    {
        return $this->hasMany(DeveloperTaskComment::class, 'developer_task_id')->with('user');
    }
}
