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

        $role = Role::where('id',Auth::user()->role_id)->first();

        $name = strtolower($role->name);

        if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") {

            $post_count = Post::where('is_deleted',0)->count();
            $category_count = Category::where('is_deleted',0)->count();
            $tag_count = Tags::where('is_deleted',0)->count();
            $user_count = User::where('is_deleted',0)->count();
            $comment_count = Comments::where('is_deleted',0)->count();
            $reply_count = CommentReplies::where('is_deleted',0)->count();
            $active_post = Post::where('is_active', 1)->where('is_deleted',0)->count();
            $inactive_post = Post::where('is_active', 0)->where('is_deleted',0)->count();

            $browser_arry  = array();
            $browser_arry_count  = array();

            // browser 
            $browsers = DB::table("usrr_info")->select('browser')->distinct()->get();
            foreach($browsers as $browser) {

                $browser_conut = DB::table("usrr_info")
                    ->where('browser',$browser->browser)->count();
                
                array_push($browser_arry , $browser->browser);
                array_push($browser_arry_count , $browser_conut);
            }

            $browser_names = json_encode($browser_arry);
            $browser_counts = json_encode($browser_arry_count);


            $platform_arry  = array();
            $platform_arry_count  = array();

            $platforms = DB::table("usrr_info")->select('pltform')->distinct()->get();
            foreach($platforms as $platform) {

                $platform_count = DB::table("usrr_info")
                    ->where('pltform',$platform->pltform)->count();
                
                array_push($platform_arry , $platform->pltform);
                array_push($platform_arry_count , $platform_count);
            }

            $platform_names = json_encode($platform_arry);
            $platform_counts = json_encode($platform_arry_count);



            $country_arry  = array();
            $country_arry_count  = array();

            $countries = DB::table("usrr_info")->select('country')->distinct()->get();
            foreach($countries as $country) {

                $country_count = DB::table("usrr_info")
                    ->where('country',$country->country)->count();
                
                array_push($country_arry , $country->country);
                array_push($country_arry_count , $country_count);
            }

            $country_names = json_encode($country_arry);
            $country_counts = json_encode($country_arry_count);

            $visitors = DB::table('usrr_info')->select(DB::raw("(COUNT(*)) as visitors"),DB::raw("MONTHNAME(date) as month"))
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->get()->toArray();


            return view('admin.dashboard.index', compact('post_count','browser_names','browser_counts','category_count', 'tag_count', 'user_count', 'comment_count', 'reply_count', 'active_post', 'inactive_post','platform_names','platform_counts','country_names','country_counts','name'));

        }else{

            $posts = Post::where('created_by',Auth::id())->where('is_deleted',0)->get();
            $category_count = Category::where('created_by',Auth::id())->where('is_deleted',0)->count();
            $tag_count = Tags::where('created_by',Auth::id())->where('is_deleted',0)->count();
            $user_count = User::where('created_by',Auth::id())->where('is_deleted',0)->count();

            $comment_count = 0;
            $reply_count = 0;

            foreach($posts as $post) {
                $comment_count = Comments::where('post_id',$post->id)->where('is_deleted',0)->count();
                $reply_count = CommentReplies::where('post_id',$post->id)->where('is_deleted',0)->count();
            }

            $active_post = Post::where('is_active', 1)->where('created_by',Auth::id())->where('is_deleted',0)->count();
            $inactive_post = Post::where('is_active', 0)->where('created_by',Auth::id())->where('is_deleted',0)->count();

            $post_count = sizeof($posts);


            return view('admin.dashboard.index', compact('post_count','category_count', 'tag_count', 'user_count', 'comment_count', 'reply_count', 'active_post', 'inactive_post','name'));
        }
    }


    public function manageUserPage() {

        $roles = Role::all();
        $permission = DB::table("permissions")->where("created_by",Auth::id())->where('title','user')->first();
        return view("admin.users.users", compact('roles','permission'));
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

                    // $request->session()->put('user_id', Auth::user()->id);

                    $role_features = DB::table('role_has_permissions')
                        ->join('feature', 'role_has_permissions.feature_id', '=', 'feature.id')
                        ->where('feature.parent_id', '=', 0)
                        ->where("is_active", "=", 1)
                        ->where('role_has_permissions.role_id', Auth::user()->role_id)->get();

                    foreach ($role_features as $feature) {
                        $sub_menus = DB::table("feature")->where('parent_id', '=', $feature->id)->where("is_active", "=", 1)->orderBy("sequence")->get();
                        $sub_menu = array();
                        foreach ($sub_menus as $sub) {
                            $ft_prmt = DB::table('role_has_permissions')
                                ->where('role_has_permissions.feature_id', $sub->id)
                                ->where('role_has_permissions.role_id', Auth::user()->role_id)->first();
                            if ($ft_prmt) {
                                array_push($sub_menu, $sub);
                            }
                        }
                        $feature->sub_menu = $sub_menu;
                    }
                    Session::put('menus', $role_features->sortBy('sequence'));
                    
                    $setting = Settings::where('created_by', Auth::user()->id)->first();
                    if($setting) {
                        Session::put('dashboard_logo', $setting->dashboard_logo);
                    }

                    $role_name = Role::where('id',Auth::user()->role_id)->select('name')->first();
                    if($role_name) {
                        Session::put('role_name', $role_name->name);
                    }

                    return redirect()->intended('/dashboard');
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
