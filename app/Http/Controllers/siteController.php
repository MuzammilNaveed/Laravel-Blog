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

class siteController extends Controller
{
    public function index() {
        return view('auth.login');
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
        

     
        $categories = Category::where('is_deleted',0)->where('parent_id','!=',0)->inRandomOrder()->limit(10)->get();

        $menus = Category::where('is_deleted',0)->where('parent_id',0)->get();

        foreach($menus as $menu) {
            $menu->sub_menu = Category::where("parent_id",$menu->id)->get()->toArray();
        }
        
        if(!isset($_COOKIE['visitors'])) {
            SetCookie('visitors', 'yes' , time() + (60*60*24*1));
            $this->gatherUserInfo();
        }

        $tags = Tags::where('is_deleted',0)->get();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();
        $setting = Settings::first();

        return view('website.tags', compact('tag','setting','categories','popular_posts','menus','tags','posts'));
    }

    public function showCategory($slug) {

        $category = Category::where('is_deleted',0)->where("slug", $slug)->first();
        $posts = Post::where('is_active',1)->where('is_deleted',0)->where("cat_id",$category->id)->paginate(4);
        $post_count = sizeof($posts);

        $categories = Category::where('is_deleted',0)->where('parent_id','!=',0)->inRandomOrder()->limit(10)->get();
        $menus = Category::where('is_deleted',0)->where('parent_id',0)->get();
        foreach($menus as $menu) {
            $menu->sub_menu = Category::where("parent_id",$menu->id)->get()->toArray();
        }
        
        if(!isset($_COOKIE['visitors'])) {
            SetCookie('visitors', 'yes' , time() + (60*60*24*1));
            $this->gatherUserInfo();
        }
        $tags = Tags::where('is_deleted',0)->get();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();
        $setting = Settings::first();
        
        return view('website.category', compact('category','setting', 'posts','tags','post_count', 'categories','popular_posts','menus'));
    }

    public function showSinglePost($slug) {
        $post = Post::where('is_deleted',0)->where("slug", $slug)->first();
        $post_category = Category::where('id',$post->cat_id)->where('is_deleted',0)->first();
        $post_author = User::where('is_deleted',0)->where('is_author',1)->where('id',$post->meta_author_id)->select('id','name','profile_pic','about')->first();

        $categories = Category::where('is_deleted',0)->where('parent_id','!=',0)->inRandomOrder()->limit(10)->get();
        $menus = Category::where('is_deleted',0)->where('parent_id',0)->get();
        foreach($menus as $menu) {
            $menu->sub_menu = Category::where("parent_id",$menu->id)->get()->toArray();
        }

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
        $comments =  Comments::where("post_id","=",$post->id)->get();
        $total_comments = sizeof($comments);
        
        foreach($comments as $comment) {
            $replies = CommentReplies::where('comment_id',$comment->id)->get();
            $comment->comment_replies = $replies;
            $total_comments += sizeof($replies);  
        }        
        
        return view("website.post", compact('post', 'categories','setting', 'posts','popular_posts','post_author','post_category','menus','comments','total_comments'));
    }


    // contact us page 
    public function staticPages(Request $request) {

        $setting = Settings::first();
        $tags = Tags::where('is_deleted',0)->get();
        $menus = Category::where('is_deleted',0)->where('parent_id',0)->get();
        foreach($menus as $menu) {
            $menu->sub_menu = Category::where("parent_id",$menu->id)->get()->toArray();
        }
        $categories = Category::where('is_deleted',0)->where('parent_id','!=',0)->inRandomOrder()->limit(10)->get();
        $popular_posts = Post::orderBy('view_count','desc')->where('is_deleted',0)->inRandomOrder()->limit(5)->get();

        if($request->path() == "contact_us") {
            return view('website.pages.contact_us',compact('setting','tags','menus','categories','popular_posts'));
        }else{
            return view('website.pages.about_us',compact('setting','tags','menus','categories','popular_posts'));
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
        $categories = Category::where('is_deleted',0)->where('parent_id','!=',0)->inRandomOrder()->limit(10)->get();
        
        $menus = Category::where('is_deleted',0)->where('parent_id',0)->get();
        foreach($menus as $menu) {
            $menu->sub_menu = Category::where("parent_id",$menu->id)->get()->toArray();
        }
        $tags = Tags::where('is_deleted',0)->get();
        $setting = Settings::first();
        $popular_posts = Post::where('is_active',1)->orderBy('view_count','desc')->where('is_deleted',0)->where('is_active',1)->inRandomOrder()->limit(5)->get();

        return view('website.author',compact('categories','setting','popular_posts','tags','posts','user','menus'));

    }


}
