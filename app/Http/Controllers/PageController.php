<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function managePages() {
        $pages = Page::all();
        return view('admin.pages.pages',compact('pages'));
    }

    public function addPages() {
        return view('admin.pages.add_page');
    }

    function insertPageData(Request $request) {

        Page::create([
            'page_name' => $request->page_name,
            'page_slug' => Str::slug($request->page_name, '-'),
            'page_desc' => $request->page_desc,
            'created_by' => Auth::user()->id,
            'published' => $request->status,
        ]);

        return response()->json([
            'message' => $request->page_name . ' Page Created Successfully.',
            'status' => 200,
            'success' => true
        ]);

    }
    public function editPage($slug) {
        $page = Page::where('page_slug',$slug)->first();
        return view('admin.pages.edit_page', compact('page'));
    }

    public function saveEditPage(Request $request) {
        Page::where('id',$request->id)->update([
            "page_name" => $request->title,
            "page_desc" =>$request->description,
            'published' => $request->status,
        ]);

        return response()->json([
            'message' => $request->title . ' Page Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }
}
