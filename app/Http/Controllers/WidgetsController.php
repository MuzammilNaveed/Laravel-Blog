<?php

namespace App\Http\Controllers;

use App\Models\Widgets;
use App\Models\Menu;
use Illuminate\Http\Request;

class WidgetsController extends Controller {

    public function index() {
        $menus = Menu::all();

        $widgets = Widgets::all();

        foreach($widgets as $key => $widget) {

            $widget_li = '
                <li data-id="'.$widget->widget_id.'" data-position="'.$key.'" class="bg-light border p-2 mt-2">
                <span class="widget-handle">
                    <p class="widget-name m-0"> '.$widget->widget_name.'
                        <!-- <span class="text-right"><i class="fa fa-caret-up"></i></span> -->
                    </p>
                </span>
                <div class="widget-content" style="display:none">
                    <form method="post" id="aboutmeWidgetForm">
                        <input type="hidden" name="id" value="aboutmeWidget">
                        <div class="form-group">
                            <label for="widget-name">Name</label>
                            <input type="text" class="form-control" name="name" value="'.$widget->name.'">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" class="form-control" rows="7">'.$widget->content.'</textarea>
                        </div>
                        <div class="widget-control-actions">
                            <div class="float-left">
                                <button class="btn btn-danger widget-control-delete">Delete</button>
                            </div>
                            <div class="float-right text-right">
                                <button class="btn btn-primary widget_save">Save</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </li>';

            $widget->list = $widget_li;
        }

        return view('admin.widgets.widget',compact('menus','widgets'));
    }

    public function saveWidget(Request $request) {

        $data = array(
            "widget_id" => $request->widget_id,
            "widget_name" => $request->widget_name,
            "name" => $request->name,
            "content" => $request->content,
            "type" => $request->type,
        );

        Widgets::create($data);

        return response()->json([
            "status" => 200,
            "message" => "Widget Saved Successfully",
            "success" => true,
        ]);
        

    }

}
