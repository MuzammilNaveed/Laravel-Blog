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
        'cat_id',
        'section',
        'image',
        'image_alt_tag',
        'dscription',
        'meta_title',
        'post_author',
        'meta_tags',
        'meta_description',
    ];

}
