<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainTask extends Model
{
    protected $fillable = ['client_id', 'title', 'description', 'user_id', 'category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'main_task_user')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(MainTaskComment::class)->latest();
    }
}
