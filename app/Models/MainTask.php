<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainTask extends Model
{
    protected $fillable = ['client_id', 'title', 'description', 'user_id'];

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
}
