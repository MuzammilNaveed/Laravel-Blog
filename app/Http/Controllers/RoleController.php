<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function manageRoles() {
        return view("admin.roles.roles");
    }

    public function index(Request $request) {
        return Role::all();
    }

    public function store(Request $request) {
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return response()->json([
            'message' => 'Role Added Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function update($id, Request $request) {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        return response()->json([
            'message' => 'Role Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function destroy($id) {
        $user = User::where('role_id',$id)->first();
        if($user) {
            return response()->json([
                'message' => 'Role Cannot be Deleted',
                'status' => 500,
                'success' => false,
            ]);
        }else{
            $role = Role::find($id);
            $role->delete();
            return response()->json([
                'message' => 'Role Deleted Successfully.',
                'status' => 200,
                'success' => true
            ]);
        }
        
    }
}
