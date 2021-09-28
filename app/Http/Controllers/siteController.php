<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tags;
use App\Models\Contact;
use App\Models\CommentReplies;
use App\Models\Newsletter;
use App\Models\Comments;
use App\Models\Settings;
use App\Models\Widgets;
use App\Models\Menu;
use App\Models\MenuItems;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class siteController extends Controller {
    
    public function index() {
        return view('auth.login');
    }

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
        $categories = Category::where('is_deleted',0)->inRandomOrder()->limit(12)->get();
        
        $setting = Settings::first();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->limit(5)->get();


        $widgets = $this->getAllWidgets();
        $menu = Menu::where('name','Main Menu')->first();
        
        $menuItems = MenuItems::where('menu_id',$menu->id)->where('parent_id',0)->orderBy('position','asc')->get();

        return view("website.index", compact('posts','setting','singleheader','feature_posts','tags','categories','popular_posts','tutorial_posts','menuItems','widgets'));
    }

    public function getAllWidgets() {
        $widgets = Widgets::orderBy('position','asc')->get();

        foreach($widgets as $widget) {

            if($widget->widget_id == "popularPostWidget") {

                $total_posts = $widget->content != null && $widget->content != " " ? $widget->content : 5;
                $widget->popularPosts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->limit($total_posts)->get();
            }

            if($widget->widget_id == "menuWidget") {
                $widget->Menu = Menu::where('id',$widget->content)->first();
                $widget->Custom_menus = MenuItems::where('menu_id',$widget->content)->get();
            }

            if($widget->widget_id == "tagWidget") {
                $count = $widget->content != null && $widget->content != " " ? $widget->content : 5;
                $widget->tags = Tags::where('is_deleted',0)->limit($count)->get();
            }

            if($widget->widget_id == "categoryWidget") {
                $count = $widget->content != null && $widget->content != " " ? $widget->content : 5;
                $widget->categories = Category::where('is_deleted',0)->limit($count)->get();
            }
        }

        return $widgets;
    }

    public function searchPosts(Request $request) {
        
        $result = Post::where("title","LIKE","%{$request->data}%")->get();
        if($result) {
            return response()->json($result);
        }
    }

    public function showTagPage($slug) {
        $tag = Tags::where("slug",$slug)->first();

        $post_tags = DB::table("post_tags")->where("tag_id",$tag->id)->get();

        $posts = array();
        foreach($post_tags as $post) {
            $all_posts = Post::where("id",$post->post_id)->get();
            $all_posts[0]['category_name'] = Category::where('id',$all_posts[0]['cat_id'])->first()->toArray();
            array_push($posts,$all_posts);
        }
             
        $categories = Category::where('is_deleted',0)->inRandomOrder()->limit(12)->get();

        if(!isset($_COOKIE['visitors'])) {
            SetCookie('visitors', 'yes' , time() + (60*60*24*1));
            $this->gatherUserInfo();
        }

        $tags = Tags::where('is_deleted',0)->get();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();
        $setting = Settings::first();

        $widgets = $this->getAllWidgets();

        $menu = Menu::where('name','Main Menu')->first();        
        $menuItems = MenuItems::where('menu_id',$menu->id)->where('parent_id',0)->orderBy('position','asc')->get();

        return view('website.tags', compact('tag','setting','categories','popular_posts','tags','posts','widgets','menuItems'));
    }

    public function showCategory($slug) {

        $category = Category::where('is_deleted',0)->where("slug", $slug)->first();
        $posts = Post::where('is_active',1)->where('is_deleted',0)->where("cat_id",$category->id)->paginate(4);
        $post_count = sizeof($posts);

        $categories = Category::where('is_deleted',0)->inRandomOrder()->limit(12)->get();

        if(!isset($_COOKIE['visitors'])) {
            SetCookie('visitors', 'yes' , time() + (60*60*24*1));
            $this->gatherUserInfo();
        }

        $tags = Tags::where('is_deleted',0)->get();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();
        $setting = Settings::first();

        $widgets = $this->getAllWidgets();
        $menu = Menu::where('name','Main Menu')->first();        
        $menuItems = MenuItems::where('menu_id',$menu->id)->where('parent_id',0)->orderBy('position','asc')->get();
        
        return view('website.category', compact('category','setting','menuItems', 'posts','tags','post_count', 'categories','popular_posts','widgets'));
    }

    public function showSinglePost($slug) {
        $post = Post::where('is_deleted',0)->where("slug", $slug)->first();
        $post_category = Category::where('id',$post->cat_id)->where('is_deleted',0)->first();
        $post_author = User::where('is_deleted',0)->where('is_author',1)->where('id',$post->meta_author_id)->select('id','name','profile_pic','about')->first();

        $categories = Category::where('is_deleted',0)->inRandomOrder()->limit(12)->get();

        $posts = Post::where('is_deleted',0)->inRandomOrder()->limit(5)->get();

        if(!isset($_COOKIE['visitors'])) {
            SetCookie('visitors', 'yes' , time() + (60*60*24*1));
            $this->gatherUserInfo();
        }

        $post->increment('view_count');
        $tags = Tags::where('is_deleted',0)->get();
        $popular_posts = Post::orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();
        $setting = Settings::first();

        $total_comments = 0;
        $comments =  Comments::where("post_id",$post->id)->where('status',1)->get();
        $total_comments = sizeof($comments);
        
        foreach($comments as $comment) {
            $replies = CommentReplies::where('comment_id',$comment->id)->where('status',1)->get();
            $comment->comment_replies = $replies;
            $total_comments += sizeof($replies);  
        }        

        $widgets = $this->getAllWidgets();
        $menu = Menu::where('name','Main Menu')->first();        
        $menuItems = MenuItems::where('menu_id',$menu->id)->where('parent_id',0)->orderBy('position','asc')->get();
        
        return view("website.post", compact('post', 'categories','setting','menuItems','tags','posts','popular_posts','post_author','post_category','comments','total_comments','widgets'));
    }

    // contact us page 
    public function staticPages(Request $request) {

        $setting = Settings::first();
        $tags = Tags::where('is_deleted',0)->get();

        $categories = Category::where('is_deleted',0)->inRandomOrder()->limit(12)->get();
        $popular_posts = Post::orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();

        $widgets = $this->getAllWidgets();

        $menu = Menu::where('name','Main Menu')->first();        
        $menuItems = MenuItems::where('menu_id',$menu->id)->where('parent_id',0)->orderBy('position','asc')->get();

        if($request->path() == "contact_us") {
            return view('website.pages.contact_us',compact('setting','menuItems','tags','categories','popular_posts','widgets'));
        }else{
            return view('website.pages.about_us',compact('setting','tags','menuItems','categories','popular_posts','widgets'));
        }           
    }

    public function postComment(Request $request) {
        $comment = new Comments();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->save();

        return response()->json([
            'message' => 'Comment Posted',
            'status' => 200,
            'success' => true
        ]);
    }

    public function getAllComments(Request $request) {
        $comments =  Comments::where("post_id","=",$request->post_id)->where('status',1)->get();

        foreach($comments as $comment) {
            $comment->comment_replies = CommentReplies::where('comment_id',$comment->id)->where('status',1)->get();
        }
        return $comments;
    }

    public function postCommentReply(Request $request) {
        $comment = new CommentReplies();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->comment_id = $request->comment_id;
        $comment->save();

        return response()->json([
            'message' => 'Reply Posted',
            'status' => 200,
            'success' => true
        ]);
    }

    public function viewAuthorPage($id) {

        $posts = Post::where('is_active',1)->where('created_by',$id)->where('is_active',1)->paginate(6);
        foreach($posts as $post) {
            $post->post_category = Category::where('id',$post->cat_id)->where('is_deleted',0)->first();
        }
        $user = User::where('id',$id)->first();
        $categories = Category::where('is_deleted',0)->inRandomOrder()->limit(12)->get();
        
        $tags = Tags::where('is_deleted',0)->get();
        $setting = Settings::first();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->where('is_active',1)->inRandomOrder()->limit(5)->get();

        $widgets = $this->getAllWidgets();

        $menu = Menu::where('name','Main Menu')->first();        
        $menuItems = MenuItems::where('menu_id',$menu->id)->where('parent_id',0)->orderBy('position','asc')->get();

        return view('website.author',compact('categories','setting','popular_posts','tags','posts','user','menuItems','widgets'));

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


    public function saveNewsletter(Request $request) {
        
        $request->validate([
            'email' => 'required|email',
        ]);

        $newsletter = Newsletter::where('email',$request->email)->first();

        if($newsletter) {
            return response()->json([
                'message' => 'you already subscribe to our newletter',
                'status' => 500,
                'success' => false,
            ]);
        }else{
            Newsletter::create([ "email" => $request->email ]);

            return response()->json([
                'message' => 'Subscribe to newsletter successfully!',
                'status' => 200,
                'success' => true,
            ]);

        }
        
    } 


    public function saveContacts(Request $request) {
        Contact::create([
            "name" => $request->name, 
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->message,
        ]);

        return redirect()->back()->with('success','Query saved successfully we will contact you soon');
    }

}
