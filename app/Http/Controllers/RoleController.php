<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Post;
use App\Models\permissions;
use App\Models\Feature;
use App\Models\Role_has_Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function manageRoles() {
        $permission = DB::table("permissions")->where("created_by",Auth::id())->where('title','role')->first();
        $features = Feature::where('parent_id',0)->get();
        return view("admin.roles.roles",compact('permission','features'));
    }

    public function index(Request $request) {
        $role = Role::where('id',Auth::user()->role_id)->first();
        $name = strtolower($role->name);

        if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") {

            $roles = Role::all();
            foreach($roles as $role) {
                $role->user_count = User::where('role_id',$role->id)->count();
            }
            
            return $roles;
        }else{
            $roles = Role::where('id',Auth::user()->role_id);
            foreach($roles as $role) {
                $role->user_count = User::where('role_id',$role->id)->count();
            }
            
            return $roles;
        }
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
                'message' => 'Role Cannot be Deleted... User Exist with this role',
                'status' => 500,
                'success' => false,
            ]);
        }else{

            $role = Role::find($id);
            $role->delete();

            Role_has_Permission::where('role_id',$id)->delete();
            $features  = Feature::whereRaw("find_in_set($id,role_id)")->get();
            $abc = array();
            
            foreach($features as $feature) {
                $parts = explode(',', $feature->role_id);
                
                while(($i = array_search($id, $parts)) !== false) {
                    unset($parts[$i]);
                }

                $or_values = implode(',', $parts);
                array_push($abc, ["role_id" => $or_values , "feature_id" => $feature->id]);
            }

            for($i = 0; $i < sizeof($abc); $i++) {
                $feature = Feature::find($abc[$i]["feature_id"]);
                $feature->role_id = $abc[$i]["role_id"];
                $feature->save();
            }

            return response()->json([
                'message' => 'Role Deleted Successfully.',
                'status' => 200,
                'success' => true
            ]);
        }
    }

    public function permissions($id) {
        // $features = Feature::where("parent_id",0)->with('sub_menu')->get();
        $features = Feature::all();
        return view("admin.permission.permissions" ,compact('id','features'));
    }


    public function managePermission() {
        $roles = Role::all();
        $permission = DB::table("permissions")->where("created_by",Auth::id())->where('title','role')->first();
        return view("admin.permission.permissions" ,compact('roles','permission'));

    }

    public function savePermission(Request $request) {

        return dd($request->all());
        // $data = array(
        //     "title" => $request->page,
        //     "role_id" => $request->role,
        //     "action" =>  $request->permissions,
        //     "created_by" =>  Auth::id(),
        // );

        // $permissions = permissions::where('title',$request->page)
        // ->where('role_id',$request->role)->where('created_by',Auth::id())->first();

        // if($permissions){

        //     permissions::where('title',$request->page)
        //     ->where('role_id',$request->role)
        //     ->where('created_by',Auth::id())->update($data);

        // }else{
        //     permissions::insert($data);
        // }  

        // return response()->json([
        //     'message' => 'Permissions Saved Successfully.',
        //     'status' => 200,
        //     'success' => true
        // ]);
    }

    public function showRolePermission(Request $request) {

        $data = permissions::where('title',$request->page)
        ->where('role_id',$request->role_id)->where('created_by',Auth::id())->first();
        
        return response()->json([
            'status' => 200,
            'success' => true,
            "permissions" => $data,
        ]);   
    }
}
