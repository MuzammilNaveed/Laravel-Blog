<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DataTables;

class categoryController extends Controller
{
    
    public function index(Request $request) {

        $role = Role::where('id',Auth::user()->role_id)->first();
        $name = strtolower($role->name);

        if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") {

            $categories = Category::where('is_deleted',0)->get();
            foreach($categories as $category) {
                $category->post_count = Post::where('cat_id',$category->id)->count();
                $category->created_by = User::where('id',$category->created_by)->first();
                $category->deleted_by = User::where('id',$category->deleted_by)->first();
            }

            if ($request->ajax()) {
                return Datatables::of($categories)->addIndexColumn()->make(true);
            }
            
            return view('users-data');

        }else{

            $categories = Category::where('is_deleted',0)->where('created_by',Auth::id())->get();
            foreach($categories as $category) {
                $category->post_count = Post::where('cat_id',$category->id)->where('created_by',Auth::id())->count();
                $category->created_by = User::where('id',Auth::id())->first();
                $category->deleted_by = User::where('id',$category->deleted_by)->first();
            }

            if ($request->ajax()) {
                return Datatables::of($categories)->addIndexColumn()->make(true);
            }
            
            return view('users-data');
        }

    }

    public function categoryPage() {
        $permission = DB::table("permissions")->where("created_by",Auth::id())->where('title','category')->first();
        $categories = Category::where('is_deleted',0)->get();
        return view('admin.category.category', compact('categories','permission'));
    }

    public function store(Request $request) {
        $cat = new Category();
        $cat->name = $request->name;
        $cat->slug = Str::slug($request->name, '-');
        $cat->description = $request->description;
        $cat->parent_id = $request->category;
        $cat->created_by = Auth::id();
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
        $cat->parent_id = $request->parent_id;
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

        // if ($request->ajax()) {
        //     $data = ProductAttribute::orderBy('id','desc');
        //     return Datatables::of($data)->addIndexColumn()->make(true);
        // }
        
        // return view('users-data');

    }

}
