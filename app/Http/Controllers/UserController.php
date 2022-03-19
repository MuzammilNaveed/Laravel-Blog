<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index user page
    public function index() {
        return view("admin.users.index");
    }

    // save / update record
    public function store() {

        $data = array(
            "name" => strip_tags( request()->name ),
            "email" =>  strip_tags( request()->email ) ,
            "role_id" => strip_tags( request()->role ),
            "status" => request()->status ?? 0,
            "created_by" => auth()->id(),
        );

        if(request()->password) {
            $data['password'] = Hash::make(request()->password);
        }

        User::updateOrCreate( ['id' => request()->id] , $data);

        return response()->json([
            'message' => 'User '. (request()->id == null ? 'Saved' : 'Updated') .' Successfully.',
            'status_code' => 200,
            'success' => true
        ]);
    }

    // get user details
    public function getUsers() {
        return response()->json([
            "users" => User::orderByDesc('id')->get() , 
            "success" => true , 
            "status_code" => 200,
        ]);
    }

    // delete user
    public function destroy($id) {
        
        $user = User::find($id);
        if($user) {

            $user->delete();
            
            return response()->json([
                'message' => 'User Deleted Successfully.',
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


    // profile
    public function profile($id) {
        $user = User::findorFail($id);
        return view("admin.users.profile" , get_defined_vars());
    }

}
