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
        $setting = Settings::where('created_by', Auth::user()->id)->first();
        return view('admin.settings.setting', compact('user','setting'));
    }

    public function changePassword(Request $request) {

        // $old_password = Hash::make($request->old_password);
        
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Password Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
        
    }

    public function saveSetting(Request $request) {

        $data = Settings::where("created_by",Auth::user()->id)->first();

        if($data) {
            
            $setting = Settings::where("created_by",Auth::user()->id)->first();
            $setting->site_name = $request->site_name;
            $setting->site_url = $request->site_url;
            $setting->site_keywords = $request->site_keyword;
            $setting->site_description = $request->site_description;
            $setting->facebook = $request->facebook;
            $setting->linkedin = $request->linkedin;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;

            if($request->hasFile('site_logo')) {
                $image = $request->file('site_logo');
                
                $file = $request->file('site_logo')->getClientOriginalName();
                $imageName = 'site_logo_'. Auth::user()->id . '.' . pathinfo($file, PATHINFO_EXTENSION);

                $filesize = $image->getSize()/1024;
                if($filesize > 2048) {
                    return response()->json([
                        'message' => 'File size exceeds 2MB',
                        'status' => 500,
                        'success' => true
                    ]);
                }else{
                    $image->move(public_path('settings'), $imageName);
                    $setting->site_logo = $imageName;
                }

            }

            if($request->hasFile('site_favicon')) {
                $image = $request->file('site_favicon');
                
                $file = $request->file('site_favicon')->getClientOriginalName();
                $imageName = 'site_favicon_'.Auth::user()->id. '.' . pathinfo($file, PATHINFO_EXTENSION);

                $filesize = $image->getSize()/1024;
                if($filesize > 2048) {
                    return response()->json([
                        'message' => 'File size exceeds 2MB',
                        'status' => 500,
                        'success' => true
                    ]);
                }else{
                    $image->move(public_path('settings'), $imageName);
                    $setting->site_favicon = $imageName;
                }

            }

            if($request->hasFile('dashboard_logo')) {
                $image = $request->file('dashboard_logo');
                
                $file = $request->file('dashboard_logo')->getClientOriginalName();
                $imageName = 'dashboard_logo_'.Auth::user()->id. '.' . pathinfo($file, PATHINFO_EXTENSION);

                $filesize = $image->getSize()/1024;
                if($filesize > 2048) {
                    return response()->json([
                        'message' => 'File size exceeds 2MB',
                        'status' => 500,
                        'success' => true
                    ]);
                }else{
                    $image->move(public_path('settings'), $imageName);
                    $setting->dashboard_logo = $imageName;
                }

            }

            $setting->created_by = Auth::user()->id;
            $setting->save();

            return response()->json([
                'message' => 'Details Updated Successfully.',
                'status' => 200,
                'success' => true
            ]);

        }else{
            $setting = new Settings();
            $setting->site_name = $request->site_name;
            $setting->site_url = $request->site_url;
            $setting->site_keywords = $request->site_keyword;
            $setting->site_description = $request->site_description;
            $setting->facebook = $request->facebook;
            $setting->linkedin = $request->linkedin;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;

            if($request->hasFile('site_logo')) {
                $image = $request->file('site_logo');
                
                $file = $request->file('site_logo')->getClientOriginalName();
                $imageName = 'site_logo_'. Auth::user()->id . '.' . pathinfo($file, PATHINFO_EXTENSION);

                $filesize = $image->getSize()/1024;
                if($filesize > 2048) {
                    return response()->json([
                        'message' => 'File size exceeds 2MB',
                        'status' => 500,
                        'success' => true
                    ]);
                }else{
                    $image->move(public_path('settings'), $imageName);
                    $setting->site_logo = $imageName;
                }

            }

            if($request->hasFile('site_favicon')) {
                $image = $request->file('site_favicon');
                
                $file = $request->file('site_favicon')->getClientOriginalName();
                $imageName = 'site_favicon_'.Auth::user()->id. '.' . pathinfo($file, PATHINFO_EXTENSION);

                $filesize = $image->getSize()/1024;
                if($filesize > 2048) {
                    return response()->json([
                        'message' => 'File size exceeds 2MB',
                        'status' => 500,
                        'success' => true
                    ]);
                }else{
                    $image->move(public_path('settings'), $imageName);
                    $setting->site_favicon = $imageName;
                }

            }

            if($request->hasFile('dashboard_logo')) {
                $image = $request->file('dashboard_logo');
                
                $file = $request->file('dashboard_logo')->getClientOriginalName();
                $imageName = 'dashboard_logo_'.Auth::user()->id. '.' . pathinfo($file, PATHINFO_EXTENSION);

                $filesize = $image->getSize()/1024;
                if($filesize > 2048) {
                    return response()->json([
                        'message' => 'File size exceeds 2MB',
                        'status' => 500,
                        'success' => true
                    ]);
                }else{
                    $image->move(public_path('settings'), $imageName);
                    $setting->dashboard_logo = $imageName;
                }

            }

            $setting->created_by = Auth::user()->id;
            $setting->save();

            return response()->json([
                'message' => 'Details Saved Successfully.',
                'status' => 200,
                'success' => true
            ]);
        }
    }

}
