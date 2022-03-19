<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\Section;

class SectionController extends Controller
{
    
    public function index() {
        $posts = Post::all();
        return view('admin.section.index' , get_defined_vars());
    }

    public function store() {
        $data = array(
            "title" => strip_tags( request()->name ),
            "post_id" =>  request()->posts != null ? implode(',', request()->posts) : NULL ,
            "status" => request()->status ?? 0,
        );

        Section::updateOrCreate( ['id' => request()->id] , $data);

        return response()->json([
            'message' => 'Section '. (request()->id == null ? 'Saved' : 'Updated') .' Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function getSections() {

        return response()->json([
            'sections' => Section::all(),
            'status_code' => 200,
            'success' => true
        ]);

    }

    public function destroy($id) {
        
        $section = Section::find($id);

        if($section) {
            $section->delete();
            return response()->json([
                'message' => 'Section Deleted Successfully.',
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
