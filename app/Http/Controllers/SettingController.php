<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class SettingController extends Controller
{
    public function index() {
        $user = User::where("id", Auth::user()->id)->first();
        return view('admin.settings.setting', compact('user'));
    }

    public function changePassword(Request $request) {

        return $old_password = Hash::make($request->old_password);
        
        $user = User::find(Auth::user()->id);
        if ($user->password == $old_password) {
            return "matched";
        }else{
            return "not";
        }
        
    }

    public function saveSetting(Request $request) {

        return $request->all();

    }

}
