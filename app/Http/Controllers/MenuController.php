<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItems;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MenuController extends Controller
{
   
    public function index() {
        return view('admin.menu.index');
    }

    public function getMenus() {
        
        return response()->json([
            "menus" => Menu::orderByDesc('id')->get() , 
            "success" => true , 
            "status_code" => 200,
        ]);

    }

    public function store() {
        $data = array(
            "name" => strip_tags( request()->name ),
            "slug" =>  Str::slug( strip_tags( request()->name ) , '-'),
            "status" => request()->status ?? 0,
        );

        Menu::updateOrCreate( ['id' => request()->id] , $data);

        return response()->json([
            'message' => 'Menu '. (request()->id == null ? 'Saved' : 'Updated') .' Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    
    public function destroy($id) {

        $tag = Menu::findOrFail($id);
        if($tag) {
            $tag->delete();
            return response()->json([
                'message' => 'Menu Deleted Successfully.',
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

    public function show($id) {
        $menu = Menu::find($id);
        $menuItems = MenuItems::where('menu_id',$id)->where('parent_id',0)->orderBy('position','asc')->get();

        return view('admin.menu.edit', get_defined_vars());
    }


    public function addMenu($id='') {
        return view('admin.menu.add_menu',compact('id'));
    }
    
    public function editMenu($id) {
        $menu = Menu::find($id);

        $menuItems = MenuItems::where('menu_id',$id)->where('parent_id',0)->orderBy('position','asc')->get();

        return view('admin.menu.edit_menu',compact('id','menuItems','menu'));
    }

    public function getTreeArray($menuId, $parentId, $treeArray = '') {

        $data = MenuItems::where('menu_id',$menuId)->where('parent_id',$parentId)->get()->toArray();

        if(!is_array($treeArray)){ $treeArray  = [];}

        foreach($data as $key => $item) {
            
            if($item['parent_id'] == 0) {
                $treeArray[] = '<li class="dd-item" data-id="' . $item['id'] . '"><div class="dd-handle">' . $item['name'] . '</div></li>';
            }

            if($item['parent_id'] != 0){
                $treeArray[] = '<li class="dd-item" data-id="'.$item['id'].'"><div class="dd-handle">'.$item['name'].'</div>
                <ol class="dd-list">';
            }

            $treeArray = $this->getTreeArray($menuId, $item['id'], $treeArray);
            
            if(array_key_last($data) == $key){
                $treeArray[] = '</ol></li>';
            }
        }

        return $treeArray;
    }


    public function updateMenuItemPostion(Request $request) {
        $menuId = $request->menu_id;
        $this->fetchTreeArray($request->data, $menuId);
        return response()->json([
            "status" => 200,
            "message" => "Setting Saved",
            "success" => true,
        ]);
    }

    public function fetchTreeArray($data, $menuId, $parentId = 0) {

        foreach($data as $key => $item) {

            $position = $key + 1;
            $id = $item['id'];

            // echo 'id:'. $id . '- parentid:' . $parentId . '-position:' . $position . '<br>';
            MenuItems::where('id',$id)->update([ "parent_id" => $parentId, 'position' => $position]);
            
            $isChildren = (isset($item['children'])) ? $item['children'] : false;

            if($isChildren) {
                $this->fetchTreeArray($isChildren,  $menuId, $id);
            }

        }

    }

    public function insertMenu(Request $request) {

        $data = array(
            "name" => strip_tags($request->name),
            "status" => ($request->enabled_menu == "on" ? 1 : 0),
        );

        Menu::create($data);

        $menu = Menu::orderBy('id','desc')->first();
        return redirect("add-menu/$menu->id")->with("success" , "Menu Saved Successfully");
    }

    public function updateMenu(Request $request) {

        $data = array(
            "name" => strip_tags($request->name),
            "status" => ($request->enabled_menu == "on" ? 1 : 0),
        );

        Menu::where('id',$request->menu_id)->update($data);

        return redirect()->back()->with("success" , "Menu Updated Successfully");

    }

    public function menuItemPage($id) {
        $categories = Category::all();
        $pages = Page::where('published',1)->get();

        $menuItems = MenuItems::where('menu_id',$id)->get();
        return view('admin.menu.menu_item',compact('id','categories','pages','menuItems'));
    }

    public function editMenuItemPage ($item_id,$menu_id) {

        $categories = Category::all();
        $pages = Page::where('published',1)->get();

        $menuItems = MenuItems::where('menu_id',$menu_id)->get();

        $menuitem = MenuItems::find($item_id);
        return view('admin.menu.edit_menu_item',compact('menu_id','categories','pages','menuItems','menuitem'));

    }

    public function updateMenuItem(Request $request) {

        $data = array(
            "name" => $request->name,
            "slug" => Str::slug($request->name, '-'),
            "type" => $request->type,
            "icon" => $request->icon,
            "target" => $request->target,
            "parent_id" => $request->parent_menu_id,
            "status" => ($request->enabled_menu == "on" ? 1 : 0),
        );

        if($request->category_id != null) {
            $data['category_id'] = $request->category_id;
        }

        if($request->page_id != null) {
            $data['page_id'] = $request->page_id;
        }

        if($request->url != null) {
            $data['url'] = $request->url;
        }

        MenuItems::where('id',$request->item_id)->update($data);
        return redirect()->back()->with("success" , "Menu Item Updated Successfully");

    }

    public function insertMenuItems(Request $request) {
        
        $data = array(
            "name" => $request->name,
            "slug" => Str::slug($request->name, '-'),
            "menu_id" => $request->menu_id,
            "type" => $request->type,
            "icon" => $request->icon,
            "target" => $request->target,
            "parent_id" => $request->parent_menu_id,
            "status" => ($request->enabled_menu == "on" ? 1 : 0),
        );

        if($request->category_id != null) {
            $data['category_id'] = $request->category_id;
        }

        if($request->page_id != null) {
            $data['page_id'] = $request->page_id;
        }

        if($request->url != null) {
            $data['url'] = $request->url;
        }

        MenuItems::create($data);
        return redirect()->back()->with("success" , "Menu Item Saved Successfully");
    }

    public function deleteMenuItem ($id) {
        MenuItems::find($id)->delete();
        return redirect()->back()->with("success" , "Menu Item Deleted Successfully");
    }

}
