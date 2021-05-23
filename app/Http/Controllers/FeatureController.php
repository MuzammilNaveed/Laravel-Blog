<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role_has_Permission;
use App\Models\Role;
use App\Models\Feature;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.feature.feature_access', compact('roles'));
    }

    public function store(Request $request)
    {
        $fl = new Feature();
        $fl->title = $request->title;
        $fl->route = $request->menu_routes;
        $fl->sequence = $request->sequence;
        $fl->parent_id = $request->parent_id;
        $fl->is_active = $request->is_active;
        $fl->feature_type = $request->feature_type;
        $fl->menu_icon = $request->icon;
        $fl->role_id = $request->role_id;
        $fl->save();

        for ($i = 0; $i < sizeof($request->roles); $i++) {
            DB::table("role_has_permissions")->insert([
                "feature_id" => $fl->id,
                "role_id" => $request->roles[$i],
            ]);
        }

        return response()->json([
            'message' => 'Feature Added Successfully',
            'status' => 200,
            'success' => true
        ]);
    }

    public function getFeatures()  {
        $features =  Feature::all();
        foreach($features as $feature) {
            $f_role_id = explode(',', $feature->role_id);
            $rl_arr_name = array();
            for($i = 0; $i < sizeof($f_role_id); $i++) {
                $role = Role::where("id","=",$f_role_id[$i])->first();
                array_push($rl_arr_name, $role->name);   
            }
            $feature->roles =  (object)$rl_arr_name;
        }
        return $features;
    }


    public function update(Request $request)
    {
        $fl = Feature::find($request->feature_id);
        $fl->title = $request->title;
        $fl->route = $request->menu_routes;
        $fl->sequence = $request->sequence;
        $fl->parent_id = $request->parent_id;
        $fl->is_active = $request->is_active;
        $fl->feature_type = $request->feature_type;
        $fl->menu_icon = $request->icon;
        $fl->role_id = $request->role_id;
        $fl->save();

        DB::table("role_has_permissions")->where("feature_id",$request->feature_id)->delete();

        for ($i = 0; $i < sizeof($request->roles); $i++) {
            DB::table("role_has_permissions")->insert([
                "feature_id" => $fl->id,
                "role_id" => $request->roles[$i],
            ]);
        }

        return response()->json([
            'message' => 'Feature  Updated Successfully',
            'status' => 200,
            'success' => true
        ]);
    }

    public function destroy($id)
    {

        DB::table("ac_features")->where('id', $id)->delete();
        return response()->json([
            'message' => 'Role deleted successfully',
            'status' => 200,
            'success' => true
        ]);
    }

    public function getFeaturesByID($id)
    {
        return Feature::find($id);
    }
}
