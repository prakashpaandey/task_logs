<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTaskComment extends Model
{
    protected $table = 'sub_task_comments';
    protected $fillable = ['sub_task_id', 'comment', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subtask()
    {
        return $this->belongsTo(Subtask::class, 'sub_task_id');
    }

    public function images()
    {
        return $this->hasMany(SubTaskCommentImage::class, 'sub_task_comment_id');
    }
}
