<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;
use App\Models\Tags;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'cat_id',
        'author',
        'tags_id',
        'status',
        'image',
        'description',
        'meta_title',
        'meta_tags',
        'meta_description',
        'created_by',
        'is_deleted',
        'deleted_by',
        'view_count',
    ];

    protected $appends = ['tags'];


    public function getTagsAttribute() {

        $tags = explode(',' , $this->tags_id);
        $tag = Tags::select(['id','name'])->whereIn('id' , $tags)->get();
        return $this->tags_name = $tag;
    }

    public function scopeWithCategory($query) {

        return $query->addSelect([

            'category_name' => Category::select('name')->whereColumn('id' , 'posts.cat_id')->limit(1) , 
            'created_by_name' => User::select('name')->whereColumn('id' , 'posts.created_by')->limit(1) , 
        
        ]);

    }
}
