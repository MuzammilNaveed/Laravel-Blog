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
        $menus = Menu::all();
        return view('admin.menu.menu', compact('menus'));
    }

    public function addMenu($id='') {
        return view('admin.menu.add_menu',compact('id'));
    }
    
    public function editMenu($id) {
        $menu = Menu::find($id);
        $menuItems = MenuItems::where('menu_id',$id)->get();

        // $items = implode(' ',$this->getTreeArray($id ,0 , []));

        // print_r($items);

        // $data = MenuItems::where('menu_id',$id)->where('parent_id',0)->get();
        return false;

        return view('admin.menu.edit_menu',compact('id','menuItems','menu','items'));
    }


    public function fetchAllMenus($menu_id , $parent_id) {

        $data = MenuItems::where('menu_id',$menu_id)->where('parent_id',$parent_id)->get();

        foreach($data as $item) {

            $item->sub = MenuItems::where('parent_id',$item->id)->get()->toArray();

            // $this->fetchAllMenus($menu_id, $item['parent_id']);

        }

        return $data;


    }



    // public function getTreeArray($menuId, $parentId, $treeArray = '') {

    //     $data = MenuItems::where('menu_id',$menuId)->where('parent_id',$parentId)->get()->toArray();

    //     if(!is_array($treeArray)){ $treeArray  = [];}

    //     foreach($data as $key => $item) {
            
    //         if($item['parent_id'] == 0) {
    //             $treeArray[] = '<li class="dd-item" data-id="' . $item['id'] . '"><div class="dd-handle">' . $item['name'] . '</div></li>';
    //         }

    //         if($item['parent_id'] != 0){
    //             $treeArray[] = '<li class="dd-item" data-id="'.$item['id'].'"><div class="dd-handle">'.$item['name'].'</div>
    //             <ol class="dd-list">';
    //         }

    //         $treeArray = $this->getTreeArray($menuId, $item['id'], $treeArray);
            
    //         if(array_key_last($data) == $key){
    //             $treeArray[] = '</ol></li>';
    //         }
    //     }

    //     return $treeArray;
    // }


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

        foreach($data as $item) {

            $id = $item['id'];

            MenuItems::where('id',$id)->update([ "parent_id" => $parentId]);
            
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

    public function menuItemPage($id) {
        $categories = Category::where('is_deleted',0)->get();
        $pages = Page::where('published',1)->get();

        $menuItems = MenuItems::where('menu_id',$id)->get();
        return view('admin.menu.menu_item',compact('id','categories','pages','menuItems'));
    }

    public function editMenuItemPage ($id) {

        $categories = Category::where('is_deleted',0)->get();
        $pages = Page::where('published',1)->get();

        $menuItems = MenuItems::where('menu_id',$id)->get();

        $item = MenuItems::find($id);
        return view('admin.menu.edit_menu_item',compact('id','categories','pages','menuItems','item'));

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

}
