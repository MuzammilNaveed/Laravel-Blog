<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tags;
use App\Models\Category;
use App\Models\Comments;
use App\Models\Section;
use App\Models\User;
use App\Models\Role;
use App\Models\CommentReplies;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Auth;
use DataTables;

class postsControllers extends Controller
{
 
    public function index() {
        return view('admin.posts.index');
    }

    public function create() {
        $tags = Tags::all();
        $categories = Category::all();
        $users = User::where('is_deleted',0)->where('is_author',1)->get();
        return view('admin.posts.create', get_defined_vars()); 
    }

    public function store() {

        $data = array(
            "title" => request()->title,
            "slug" => Str::slug(request()->title, '-'),
            "cat_id" => request()->category , 
            "tags_id" =>  request()->tags != null ? implode(',', request()->tags) : NULL,
            "author" => request()->author , 
            "status" => request()->status , 
            "description" => request()->description,
            "meta_title" => request()->title,
            "meta_tags" => request()->meta_tags,
            "meta_description" => request()->meta_description,
            "created_by" => auth()->id(),
        );

        
        if(request()->hasFile('image') ) {

            $image = request()->file('image');
            $filename = strtolower($image->getClientOriginalName());
            $image->storeAs('posts/',  $filename ,'public');
            
            $data['image']  = 'storage/posts/' . $filename; 
        }

        Post::updateOrCreate( ['id' => request()->id] , $data);

        return response()->json([
            'message' => 'Post ' . (request()->id == null ? 'Created' : 'Updated') .' Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }


    public function getPosts() {

        return response()->json([
            "posts" => Post::withCategory()->get() , 
            "success" => true , 
            "status_code" => 200,
        ]);
    }

    public function show($id) {
        $data = Post::where('id' , $id)->withCategory()->first();
        return view('admin.posts.view' , get_defined_vars() );
    }

    public function edit($id) {
        $data = Post::where('id' , $id)->withCategory()->first();
        $tags = Tags::all();
        $categories = Category::all();
        $users = User::where('is_deleted',0)->where('is_author',1)->get();

        // dd($data->toArray());
        return view('admin.posts.edit' , get_defined_vars() );
    }



    public function updatePost(Request $request) {

        $post = Post::find($request->post_id);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->cat_id = $request->category;
        $post->section = $request->section;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = rand(). '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }

        $post->description = $request->description;
        $post->created_by = Auth::user()->id;

        $post->meta_author_id = $request->author_id;
        $post->post_img_alt = $request->post_img_alt;
        $post->meta_tags = $request->meta_tags;
        $post->meta_description = $request->meta_description;
        $post->meta_author = $request->meta_author;
        $post->meta_title = $request->meta_title;
        $post->save();

        DB::table("post_tags")->where("post_id",'=',$request->post_id)->delete();

        for($i =0; $i < sizeof($request->tags); $i++ ) {
            
            DB::table("post_tags")->insert([
                'post_id' => $post->id,
                "tag_id" => $request->tags[$i],
            ]);
        }       

        return response()->json([
            'message' => 'Post Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function activePost($id,Request $request) {
        DB::table("posts")->where("id","=",$id)->update([
            "is_active" => $request->is_active,
        ]);
        return response()->json([
            'message' => 'Post Status Changed Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }


    public function editPostPage($id) {

        $post =  Post::where('id',$id)->first();
 
        $post_tags = DB::table("post_tags")->where("post_id","=",$post->id)->get();
        $tag_arr = array();

        for($i =0; $i < sizeof($post_tags); $i++) {
            array_push($tag_arr, $post_tags[$i]->tag_id);
        }
        
        $post_all_tags = json_encode($tag_arr);
        $tags = Tags::all();
        $categories = Category::all();
        $users = User::all();
        return view("admin.posts.edit_post",compact('categories','tags','post','post_all_tags','users'));
    }

    public function viewPost($id) {

        $post =  Post::where('id',$id)->first();
 
        $post_tags = DB::table("post_tags")->where("post_id",$post->id)->get();

        foreach($post_tags as $post_tag) {
    
            $post_tag->tags = Tags::where('id','=',$post_tag->tag_id)->first()->toArray();

        }
        
        
        $category = Category::where('id',$post->cat_id)->first();
        $users = User::all();
        return view("admin.posts.view_posts",compact('category','post_tags','post','users'));
    }


    public function uploadPostImages(Request $request) {
        
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["image_param"]["name"]);
        $extension = end($temp);
        if(in_array($extension, $allowedExts)) {
            $business_name = sha1(microtime()) . "." .$extension;
            move_uploaded_file($_FILES["image_param"]["tmp_name"], getcwd() . "/uploads/" . $business_name);
            $response = new \StdClass;
            $response->link =  URL::to('') . "/uploads/" .$business_name;
            echo stripslashes(json_encode($response));
        }
    }  

    public function deletePostImages(Request $request) {

        unlink( public_path('uploads') . '/' . $request->image_name );      
        
    }

   

   
        
    


    // comment page

    public function comments() {
        return view("admin.comment.comment");
    }

    public function getComments() {
        $role = Role::where('id',Auth::user()->role_id)->first();
        $name = strtolower($role->name);

        if( $name == "admin" || $name == "administrator" || $name == "super admin" || $name == "super administrator") {
            $comments =  Comments::with('post')->get();

            foreach($comments as $comment) {
                $comment->replies = CommentReplies::where("comment_id",'=',$comment->id)->get()->count();
            }
        }else{
            $comments =  Comments::with('post')->get();

            foreach($comments as $comment) {
                $comment->replies = CommentReplies::where("comment_id",'=',$comment->id)->get()->count();
            }
        }
        return $comments;
    }
    

    public function getCommentReplieByID($id) {
        return DB::table("comment_replies")->where("comment_id",'=',$id)->get();
    }

    public function approveComment(Request $request) {

        if($request->action == "approve") {
            $comment = Comments::find($request->id);
            $comment->status = 1;
            $comment->save();
            return response()->json([
                'message' => 'Comment Approved Successfully',
                'status' => 200,
                'success' => true
            ]);
        }else{
            $comment = Comments::find($request->id);
            $comment->status = 2;
            $comment->save();
            return response()->json([
                'message' => 'Comment Rejected Successfully',
                'status' => 200,
                'success' => true
            ]);
        }
    }

    public function approveCommentReply(Request $request) {

        if($request->action == "approve") {

            $cmt_reply = CommentReplies::find($request->id);
            $comment_id = $cmt_reply->comment_id;

            $cmt = Comments::find($comment_id);

            if($cmt->status == 0) {
                return response()->json([
                    'message' => 'First Approved Comment please...!',
                    'status' => 500,
                    'success' => false,
                ]);
            }else if($cmt->status == 2) {
                return response()->json([
                    'message' => 'Comment Dis-approved... Reply Cannot be Approved.',
                    'status' => 500,
                    'success' => false,
                ]);
            }else{

                $cmt_reply->status = 1;
                $cmt_reply->save();
                return response()->json([
                    'message' => 'Comment Reply Approved Successfully',
                    'status' => 200,
                    'success' => true
                ]);
            }

        }else{
            $cmt_reply = CommentReplies::find($request->id);
            $cmt_reply->status = 2;
                $cmt_reply->save();
                return response()->json([
                    'message' => 'Comment Dis-approve Successfully',
                    'status' => 200,
                    'success' => true
                ]);
        }

    }

    public function commentDetails(Request $request) {
        return Comments::where('id',$request->id)->get();
    }

    public function viewComment($id,$type) {

        if($type == "comment") {
            $comment = Comments::where('id',$id)->first();
            $post = Post::where('id',$comment->post_id)->first();
        }else if($type == "reply") {
            $comment = CommentReplies::where('id',$id)->first();
            $post = Post::where('id',$comment->post_id)->first();
        }

        return view('admin.comment.view_comment',compact('comment','post'));

    }

}