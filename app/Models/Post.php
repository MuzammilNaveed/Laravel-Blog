<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'cat_id',
        'section',
        'is_active',
        'image',
        'description',
        'post_img_alt',
        'meta_title',
        'meta_author_id',
        'meta_author',
        'meta_tags',
        'meta_description',
        'created_by',
        'is_deleted',
        'deleted_by',
        'view_count',
    ];

}
