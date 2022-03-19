<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use App\Models\Section;
use App\Models\User;
use App\Models\Role;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;

class TagsController extends Controller
{

    public function index() {
        return view('admin.tags.tag');
    }

    public function getTags() {
        
        return response()->json([
            "tags" => Tags::orderByDesc('id')->get() , 
            "success" => true , 
            "status_code" => 200,
        ]);

    }

    public function store(Request $request) {
        $data = array(
            "name" => strip_tags( $request->name ),
            "slug" =>  Str::slug( strip_tags( $request->name ) , '-'),
            "status" => request()->status ?? 0,
        );

        Tags::updateOrCreate( ['id' => request()->id] , $data);

        return response()->json([
            'message' => 'Tag '. ($request->id == null ? 'Saved' : 'Updated') .' Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function destroy($id) {

        $tag = Tags::find($id);
        if($tag) {
            $tag->delete();
            return response()->json([
                'message' => 'Tag Deleted Successfully.',
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


    // section

    public function section() {
        return view('admin.section.index');
    }

    public function get_sections(Request $request) {
        
        $sections = Section::orderBy('id','desc')->withCount('posts')->get();

        if ($request->ajax()) {
            return Datatables::of($sections)->addIndexColumn()->make(true);
        }
    }

    public function save_section(Request $request) {
        
        $data = array(
            "title" => $request->title,
            "status" => $request->status == "on" ? 1 : 0,
        );
        if($request->id == null && $request->id == "") {
            Section::create($data);
            $message = 'Section Saved Successfully';
        }else{
            Section::where('id',$request->id)->update($data);
            $message = 'Section Updated Successfully';
        }

        return response()->json([
            'message' => $message,
            'status' => 200,
            'success' => true
        ]);

    }


    public function delete_section(Request $request) {

        $post = Post::where("section",$request->id)->count();

        if($post > 0) {
            return response()->json([
                'message' => 'Depended Section Cannot be Deleted',
                'status' => 500,
                'success' => false
            ]);
        }else{
            Section::where('id',$request->id)->delete();
            return response()->json([
                'message' => 'Section Deleted Successfully.',
                'status' => 200,
                'success' => true
            ]);
        }

    }

}
