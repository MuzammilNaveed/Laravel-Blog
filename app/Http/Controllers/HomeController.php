<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use App\Models\Category;
use App\Models\Tags;
use App\Models\CommentReplies;
use App\Models\Comments;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use GuzzleHttp\Cookie\SetCookie;

class HomeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public static $setting = '';



    public function userHomePage(Request $request) {
        $singleheader = Post::where('is_active',1)->where('section',1)->inRandomOrder()->limit(1)->first();
        $singleheader['category']  = Category::where('id',$singleheader->cat_id)->first();


        $posts = Post::where('is_active',1)->where('section',1)->where('id','!=',$singleheader->id)->inRandomOrder()->limit(2)->get();
        foreach($posts as $post) {
            $post->category  = Category::where('id',$post['cat_id'])->first()->toArray();
        } 
        

        $feature_posts = Post::where('is_active',1)->where('section',2)->inRandomOrder()->limit(4)->get();
        foreach($feature_posts as $feature_post) {
            $feature_post->category  = Category::where('id',$feature_post['cat_id'])->first()->toArray();
        } 

        $tutorial_posts = Post::where('is_active',1)->where('section',3)->inRandomOrder()->paginate(4);
        
        foreach($tutorial_posts as $post) {
            $post->category  = Category::where('id',$post['cat_id'])->first()->toArray();
        } 

        if(!isset($_COOKIE['visitors'])) {
            SetCookie('visitors', 'yes' , time() + (60*60*24*1));
            $this->gatherUserInfo();
        }

        $tags = Tags::where('is_deleted',0)->get();
        $categories = Category::where('is_deleted',0)->where('parent_id','!=',0)->inRandomOrder()->limit(10)->get();
        
        $menus = Category::where('is_deleted',0)->where('parent_id',0)->get();
        foreach($menus as $menu) {
            $menu->sub_menu = Category::where("parent_id",$menu->id)->get()->toArray();
        }

        $setting = Settings::first();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->limit(5)->get();

        return view("website.index", compact('posts','setting','singleheader','feature_posts','tags','categories','popular_posts','tutorial_posts','menus'));
    }


    public function gatherUserInfo() {

        $geoip = geoip()->getLocation(\Request::ip());
        $agent = new Agent();
        $platform = $agent->platform();
        $browser = $agent->browser();

        DB::table("usrr_info")->insert([
            "date" => Carbon::now(),
            "ip_add" => $geoip->ip,
            "country" => $geoip->country,
            "city" => $geoip->city,
            "state" => $geoip->state_name,
            "postal_code" => $geoip->postal_code,
            "lat" => $geoip->lat,
            "longi" => $geoip->lon,
            "time_zone" => $geoip->timezone,
            "pltform" => $platform,
            "pltform_version" => $agent->version($platform),
            "browser" => $browser,
            "browser_version" => $agent->version($browser),
            "devices" => $agent->device(),
            "desktop" => $agent->isDesktop(),
            "phone" => $agent->isPhone(),
        ]);

    }

    
    // for dashboard create user
    public function dashboard() {
        return view('home');
    }


    public function manageUserPage() {

        return view("admin.users.users");
    }

    public function UserLogin(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {

            if ($user->is_deleted == 1) {
                return redirect()->back()->with('nouser', 'No such user find.');
            } else if ($user->status != 1) {
                return redirect()->back()->with('deactive', 'Contact admin for account activation');
            } else {

                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {

                    // $role_features = DB::table('role_has_permissions')
                    //     ->join('feature', 'role_has_permissions.feature_id', '=', 'feature.id')
                    //     ->where('feature.parent_id', '=', 0)
                    //     ->where("is_active", "=", 1)
                    //     ->where('role_has_permissions.role_id', Auth::user()->role_id)->get();

                    // foreach ($role_features as $feature) {
                    //     $sub_menus = DB::table("feature")->where('parent_id', '=', $feature->id)->where("is_active", "=", 1)->orderBy("sequence")->get();
                    //     $sub_menu = array();
                    //     foreach ($sub_menus as $sub) {
                    //         $ft_prmt = DB::table('role_has_permissions')
                    //             ->where('role_has_permissions.feature_id', $sub->id)
                    //             ->where('role_has_permissions.role_id', Auth::user()->role_id)->first();
                    //         if ($ft_prmt) {
                    //             array_push($sub_menu, $sub);
                    //         }
                    //     }
                    //     $feature->sub_menu = $sub_menu;
                    // }
                    // Session::put('menus', $role_features->sortBy('sequence'));
                    
                    // $setting = Settings::where('created_by', auth()->id())->first();
                    // if($setting) {
                    //     Session::put('dashboard_logo', $setting->dashboard_logo);
                    // }

                    // $role_name = Role::where('id',Auth::user()->role_id)->select('name')->first();
                    // if($role_name) {
                    //     Session::put('role_name', $role_name->name);
                    // }

                    return redirect()->route('home');
                } else {
                    return redirect()->back()->with('deactive', 'Password not matched');
                }
            }
        } else {
            return redirect()->back()->with('nouser', 'No such user find.');
        }
    }

    public function logout(Request $request){

        Auth::logout();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

    }

    public function createUser(Request $request) {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->instagram = $request->instagram;
        $user->twitter = $request->twitter;
        $user->status = $request->status;
        $user->is_author = $request->author;

        if($request->profile_pic) {
            $image = $request->file('profile_pic');
            $imageName = rand() . '.' . $image->extension();
            $image->move(public_path('users'), $imageName);
    
            $user->profile_pic = $imageName;
        }       
        $user->created_by = Auth::user()->id;
        $user->save();
        return response()->json([
            'message' => 'User Successfully Created',
            'success' => true,
            'status' => 200
        ]);
    }

    public function getAllUsers() {
        $role = Role::where('id',Auth::user()->role_id)->first();
        $name = strtolower($role->name);

        if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") {
            $users =  User::where('is_deleted',0)->get();
            foreach($users as $user) {
                $user->role = Role::where('id',$user->role_id)->select('name')->first();
            }
            return $users;
        }else{
            $users =  User::where('is_deleted',0)->where('created_by',Auth::id())->get();
            foreach($users as $user) {
                $user->role = Role::where('id',$user->role_id)->select('name')->first();
            }
            return $users;
        }
    }

    public function updateUser(Request $request){

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $user->instagram = $request->instagram;
        $user->twitter = $request->twitter;
        $user->status = $request->status;

        if ($request->hasFile('edit_profile_pic')) {

            $image = $request->file('edit_profile_pic');
            $imageName = rand() . '.' . $image->extension();
            $image->move(public_path('users'), $imageName);

            $user->profile_pic = $imageName;
        }

        $user->created_by = Auth::user()->id;
        $user->save();
        return response()->json([
            'message' => 'User Detail Updated Successfully',
            'success' => true,
            'status' => 200
        ]);
    }

    public function userDetail(Request $request) {
        if($request->page == "post") {
            $user =  User::find($request->id);
            $user->role = Role::find($user->role_id);
            return $user;
        }else{
            return User::where('role_id',$request->id)->get();
        }
        
    }


    public function deleteUser(Request $request) {
        
        $posts = Post::where('created_by',$request->id)->count();

        if($posts > 0) {
            return response()->json([
                'message' => 'User Cannot be deleted... User have Posts',
                'success' => false,
                'status' => 500
            ]);
        }else{
            $user = User::where('id',$request->id)->first();
            $user->is_deleted = 1;
            $user->deleted_by = Auth::user()->id;
            $user->save();
            return response()->json([
                'message' => 'User Deleted Successfully',
                'success' => true,
                'status' => 200
            ]);
        }
    }

}
