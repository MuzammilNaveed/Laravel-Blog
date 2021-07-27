<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReplies extends Model
{

    protected $table = 'comment_replies';
    protected $fillable = ['name','email','comment','post_id',
    'status','comment_id','is_deleted','deleted_by'];
    use HasFactory;
}
