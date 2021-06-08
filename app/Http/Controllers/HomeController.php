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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;


class HomeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        return view('auth.login');
    }

    public function userHomePage() {
        if (Auth::user()) {
            return redirect()->intended('/dashboard');
        } else {
            
            $singleheader = Post::where('section',1)->inRandomOrder()->limit(1)->first()->toArray();

            $posts = Post::where('section',1)->where('id','!=',$singleheader['id'])->inRandomOrder()->limit(2)->get();

            $feature_posts = Post::where('section',2)->inRandomOrder()->limit(4)->get();

            // dd($singleheader);
            $session = 'post_' . \Request::ip();
            if(!Session::has($session)) {
                $this->gatherUserInfo();
                Session::put($session , 1);
            }


            return view("website.index", compact('posts','singleheader','feature_posts'));
        }
    }

    public function showSinglePost($slug) {
        $post = Post::where("slug", $slug)->first();
        $categories = Category::all();
        $posts = Post::all();

        $session = 'post_' . \Request::ip();
        if(!Session::has($session)) {
            $this->gatherUserInfo();
            Session::put($session , 1);
        }

        return view("website.post", compact('post', 'categories', 'posts'));
    }

    public function showCategory($slug) {

        $category = Category::where("slug", $slug)->first();
        $posts = Post::where("cat_id",$category->id)->get();
        $post_count = sizeof($posts);
        $categories = Category::all();
        $recent_posts = Post::get();

        $session = 'post_' . \Request::ip();
        if(!Session::has($session)) {
            $this->gatherUserInfo();
            Session::put($session , 1);
        }

        return view('website.category', compact('category', 'posts', 'post_count', 'categories', 'recent_posts'));
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

        $post_count = Post::count();
        $category_count = Category::count();
        $tag_count = Tags::count();
        $user_count = User::count();
        $comment_count = Comments::count();
        $reply_count = CommentReplies::count();
        $active_post = Post::where('is_active', 1)->count();
        $inactive_post = Post::where('is_active', 0)->count();

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






        return view('admin.dashboard.index', compact('post_count','browser_names','browser_counts','category_count', 'tag_count', 'user_count', 'comment_count', 'reply_count', 'active_post', 'inactive_post','platform_names','platform_counts','country_names','country_counts'));
    }


    public function manageUserPage() {

        $roles = Role::all();
        return view("admin.users.users", compact('roles'));
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
        return redirect('/');

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

        $image = $request->file('profile_pic');
        $imageName = rand() . '.' . $image->extension();
        $image->move(public_path('users'), $imageName);

        $user->profile_pic = $imageName;
        $user->created_by = Auth::user()->id;
        $user->save();
        return response()->json([
            'message' => 'User Successfully Created',
            'success' => true,
            'status' => 200
        ]);
    }

    public function getAllUsers() {
        return User::all();
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
}
