<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class siteController extends Controller
{
    
    public function saveContactUs(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        DB::table("contact_us")->insert([
            "name" => $request->name,
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->message,
        ]);

        return redirect()->back()->with(["success" => "Your query submitted successfully .. admin will contact you shorly"]);
    }
}
