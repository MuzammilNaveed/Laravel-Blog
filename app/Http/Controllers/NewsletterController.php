<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use DataTables;

class NewsletterController extends Controller {
    
    public function index() {
        return view('admin.newsletter.newletter');
    }

    public function get_all_newletters(Request $request) {

        $newletters = Newsletter::all();
        if ($request->ajax()) {
            return Datatables::of($newletters)->addIndexColumn()->make(true);
        }
        return view('users-data');
    }

}
