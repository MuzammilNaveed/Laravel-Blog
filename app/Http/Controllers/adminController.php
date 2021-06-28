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
}
