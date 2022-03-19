<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DataTables;

class CategoryController extends Controller
{
    
    public function index() {
        return view('admin.category.category');
    }

    public function getCategories() {

        return response()->json([
            "categories" => Category::orderByDesc('id')->get() , 
            "success" => true , 
            "status_code" => 200,
        ]);
        
    }


    public function store() {
        $data = array(
            "name" => strip_tags( request()->name ),
            "slug" =>  Str::slug( strip_tags( request()->name ) , '-'),
            "description" => strip_tags( request()->description ),
            "status" => request()->status ?? 0,
            "created_by" => auth()->id(),
        );

        Category::updateOrCreate( ['id' => request()->id] , $data);

        return response()->json([
            'message' => 'Category '. (request()->id == null ? 'Saved' : 'Updated') .' Successfully.',
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
            $category = Category::find($id);
            if($category) {

                $category->delete();
                
                return response()->json([
                    'message' => 'Category Deleted Successfully.',
                    'status' => 200,
                    'success' => true
                ]);
            }else{
                return response()->json([
                    'message' => 'Something went wrong',
                    'status' => 500,
                    'success' => false
                ]);
            }
        }

    }

}
