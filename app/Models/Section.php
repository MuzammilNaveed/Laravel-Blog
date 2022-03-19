<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Section extends Model
{
    protected $table = 'sections';
    protected $fillable = ['title','post_id','status'];
    use HasFactory;

    protected $appends = ['posts'];


    public function getPostsAttribute() {

        $posts_id = explode(',' , $this->post_id);
        $post = Post::select(['id','title'])->whereIn('id' , $posts_id)->get();
        return $post;

    }

    


}
