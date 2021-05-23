<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tags;
use App\Models\Category;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {
        return Post::all();
    }

    public function addPostPage() {
        $tags = Tags::all();
        $categories = Category::all();
        return view('admin.posts.add_post',compact('categories','tags')); 
    }



}
