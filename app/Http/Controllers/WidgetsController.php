<?php

namespace App\Http\Controllers;

use App\Models\Widgets;
use App\Models\Menu;
use Illuminate\Http\Request;

class WidgetsController extends Controller {

    public function index() {
        $menus = Menu::where('status',1)->get();
        return view('admin.widgets.widget',compact('menus'));
    }

    public function showAllWidget() {
        $widgets = Widgets::orderBy('position')->get();
        return $widgets;
    }

    public function saveWidget(Request $request) {

        if($request->type == 'position_update') {
            
            $values = json_decode($request->positions);

            for($i = 0; $i < sizeof($values); $i++) {

                Widgets::where('id',$values[$i]->widget_id)->where("type",$values[$i]->type)->update([
                    "position" => $values[$i]->position,
                ]);

            }


        }else{
            $data = array(
                "widget_id" => $request->widget_id,
                "widget_name" => $request->widget_name,
                "type" => $request->type,
                "name" => $request->name,
                "content" => $request->content,
            );
    
            Widgets::create($data);
            
        }

        return response()->json([
            "status" => 200,
            "message" => "Widget Saved Successfully",
            "success" => true,
        ]);

    }

    public function deleteWidget(Request $request) {

        $widget = Widgets::find($request->id);
        $widget->delete();

        return response()->json([
            "status" => 200,
            "message" => "Widget Deleted Successfully",
            "success" => true,
        ]);

    }

}
