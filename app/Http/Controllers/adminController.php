<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Page;
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
}
