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

    public function userHomePage()
    {
        if (Auth::user()) {
            return redirect()->intended('/dashboard');
        } else {
            $posts = Post::all();
            return view("website.index", compact('posts'));
        }
    }

    public function showSinglePost($slug)
    {
        $post = DB::Table("posts")->where("slug", "=", $slug)->first();
        $categories = DB::Table("categories")->get();
        $posts = DB::Table("posts")->get();
        return view("website.post", compact('post', 'categories', 'posts'));
    }

    public function showCategory($slug)
    {
        $category = DB::Table("categories")->where("slug", "=", $slug)->first();
        $posts = DB::Table("posts")->where("cat_id", "=", $category->id)->get();
        $post_count = sizeof($posts);
        $categories = DB::Table("categories")->get();
        $recent_posts = DB::Table("posts")->get();

        return view('website.category', compact('category', 'posts', 'post_count', 'categories', 'recent_posts'));
    }

    // for dashboard create user
    public function dashboard()
    {
        $post_count = Post::count();
        $category_count = Category::count();
        $tag_count = Tags::count();
        $user_count = User::count();
        $comment_count = Comments::count();
        $reply_count = CommentReplies::count();
        $active_post = Post::where('is_active', 1)->count();
        $inactive_post = Post::where('is_active', 0)->count();
        return view('admin.dashboard.index', compact('post_count', 'category_count', 'tag_count', 'user_count', 'comment_count', 'reply_count', 'active_post', 'inactive_post'));
    }


    public function manageUserPage()
    {
        $roles = Role::all();
        return view("admin.users.users", compact('roles'));
    }

    public function UserLogin(Request $request)
    {

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

    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function createUser(Request $request)
    {

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

    public function getAllUsers()
    {
        return User::all();
    }

    public function updateUser(Request $request)
    {

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
