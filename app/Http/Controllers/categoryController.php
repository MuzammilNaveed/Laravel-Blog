<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

class categoryController extends Controller
{
    
    public function index(Request $request) {
        $categories = Category::where('is_deleted',0)->get();
        foreach($categories as $category) {
            $category->post_count = Post::where('cat_id',$category->id)->count();
        }
        return $categories;
    }

    public function store(Request $request) {
        $cat = new Category();
        $cat->name = $request->name;
        $cat->slug = Str::slug($request->name, '-');
        $cat->description = $request->description;
        $cat->save();

        return response()->json([
            'message' => 'Category Added Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function update($id, Request $request) {
        $cat = Category::find($id);
        $cat->name = $request->name;
        $cat->slug = Str::slug($request->name, '-');
        $cat->description = $request->description;
        $cat->save();

        return response()->json([
            'message' => 'Category Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }
    public function destroy($id) {
        
        $post = Post::where("cat_id",$id)->count();

        if($post > 0) {
            return response()->json([
                'message' => 'Depended Category Cannot be Deleted',
                'status' => 500,
                'success' => false
            ]);
        }else{
            Category::find($id)->delete();
            return response()->json([
                'message' => 'Category Deleted Successfully.',
                'status' => 200,
                'success' => true
            ]);
        }

    }

    public function viewCategoryPosts(Request $request) {

        $posts = Post::where('cat_id',$request->id)->where('is_deleted',0)->get();
        return $posts;

    }

}
