<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{

    protected $table = 'comments';
    protected $fillable = ['name','email','comment','post_id','status','is_deleted','deleted_by'];

    use HasFactory;


    public function post() {
        return $this->hasOne(Post::class , 'id' , 'post_id');
    }
}
