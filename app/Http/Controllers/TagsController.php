<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;

class TagsController extends Controller
{
    public function index(Request $request) {
        $role = Role::where('id',Auth::user()->role_id)->first();
        $name = strtolower($role->name);

        if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") {

            $tags = Tags::where("is_deleted",0)->get();
            foreach($tags as $tag) {
                $tag->created_by = User::where('id',$tag->created_by)->first();
            }
            if ($request->ajax()) {
                return Datatables::of($tags)->addIndexColumn()->make(true);
            }
            return view('users-data');

        }else{

            $tags = Tags::where("is_deleted",0)->where('created_by',Auth::id())->get();
            foreach($tags as $tag) {
                $tag->created_by = User::where('id',$tag->created_by)->first();
            }
            if ($request->ajax()) {
                return Datatables::of($tags)->addIndexColumn()->make(true);
            }
            return view('users-data');
            
        }
    }

    public function tagPage() {
        $permission = DB::table("permissions")->where("created_by",Auth::id())->where('title','tags')->first();
        return view('admin.tags.tag',compact('permission'));
    }

    public function store(Request $request) {
        $tag = new Tags();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return response()->json([
            'message' => 'Tag Added Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function update($id, Request $request) {
        $tag = Tags::find($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return response()->json([
            'message' => 'Tag Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function destroy($id) {

        $post_tags = DB::table("post_tags")->where("tag_id",$id)->count();

        if($post_tags > 0) {
            return response()->json([
                'message' => 'Tag Used in Post Cannot be Deleted',
                'status' => 500,
                'success' => false
            ]);
        }else{
            $tag = Tags::find($id);
            $tag->is_deleted = 1;
            $tag->deleted_by = Auth::user()->id;
            $tag->save();
            return response()->json([
                'message' => 'Tag Deleted Successfully.',
                'status' => 200,
                'success' => true
            ]);
        }        
    }

}
