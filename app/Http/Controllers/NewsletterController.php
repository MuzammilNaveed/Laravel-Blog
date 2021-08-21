<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller {
    
    public function index() {
        return view('admin.newsletter.newletter');
    }

}
