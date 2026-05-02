<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTaskCommentImage extends Model
{
    protected $table = 'sub_task_comment_images';
    protected $fillable = ['sub_task_comment_id', 'image_path'];

    public function comment()
    {
        return $this->belongsTo(SubTaskComment::class, 'sub_task_comment_id');
    }
}
