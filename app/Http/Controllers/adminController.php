<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class adminController extends Controller
{
    //
    public function index() {
        return view('admin.visitors.visitors');
    }

    public function getUserInfo() {
        return DB::table("usrr_info")->get();
    }


    // manage pages
    public function managePages() {
        return view('admin.pages.page');
    }

    public function addPages() {
        return view('admin.pages.add_page');
    }

    function insertPageData(Request $request) {

        DB::table('pages')->insert([
            'page_name' => $request->page_name,
            'page_slug' => Str::slug($request->page_name, '-'),
            'page_desc' => $request->page_desc,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json([
            'message' => $request->page_name . ' Page Created Successfully.',
            'status' => 200,
            'success' => true
        ]);

    }

    public function getAllPages() {
        return DB::table('pages')->get();
    }

    public function editPage($slug) {
        $page = DB::table('pages')->where('page_slug',$slug)->first();
        return view('admin.pages.edit_page', compact('page'));
    }

    public function saveEditPage(Request $request) {
        DB::table('pages')->where('id',$request->id)->update([
            "page_name" => $request->title,
            "page_desc" =>$request->description,
        ]);

        return response()->json([
            'message' => $request->title . ' Page Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }
}
