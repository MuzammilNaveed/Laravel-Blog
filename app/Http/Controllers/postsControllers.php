<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tags;
use App\Models\Category;
use App\Models\Comments;
use App\Models\User;
use App\Models\CommentReplies;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Auth;

class postsControllers extends Controller
{
    //
    public function index(Request $request) {
        $posts =  Post::whereBetween('created_at', [$request->from, $request->to])->get();

        foreach($posts as $post) {
            $category = Category::where("id","=",$post->cat_id)->select("name")->get();         
            $post_tags = DB::table("post_tags")->where("post_id","=",$post->id)
            ->join('tags','post_tags.tag_id','tags.id')
            ->select('name')
            ->get();

            $post->category = $category;
            $post->tags = $post_tags;          

        }
        return $posts;

    }

    public function addPostPage() {
        $tags = Tags::all();
        $categories = Category::all();
        $users = User::all();
        return view('admin.posts.add_post',compact('categories','tags','users')); 
    }

    public function store(Request $request) {

        $image = $request->file('image');
        $imageName = rand(). '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->cat_id = $request->category;
        $post->section = $request->section;
        $post->image = $imageName;
        $post->description = $request->description;
        $post->created_by = Auth::user()->id;

        $post->meta_author_id = $request->author_id;
        $post->post_img_alt = $request->post_img_alt;
        $post->meta_tags = $request->meta_tags;
        $post->meta_description = $request->meta_description;
        $post->meta_author = $request->meta_author;
        $post->meta_title = $request->meta_title;
        $post->save();

        for($i =0; $i < sizeof($request->tags); $i++ ) {
            DB::table("post_tags")->insert([
                'post_id' => $post->id,
                "tag_id" => $request->tags[$i],
            ]);
        }       

        return response()->json([
            'message' => 'Post Created Successfully.',
            'status' => 200,
            'success' => true
        ]);
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

        return $request->src;
        
        try {
            $response = FroalaEditor_Image::delete($_POST['src']);
            echo stripslashes(json_encode('Success'));
          }
          catch (Exception $e) {
            http_response_code(404);
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
        return Comments::where("post_id","=",$request->post_id)->get();
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


    // comment page

    public function comments() {
        return view("admin.comment.comment");
    }

    public function getComments() {
        $comments =  Comments::all();

        foreach($comments as $comment) {
            $comment->post = DB::table("posts")->where("id",'=',$comment->post_id)->first();
            $comment->replies = DB::table("comment_replies")->where("comment_id",'=',$comment->id)->get()->count();
        }

        return $comments;
    }

    public function getCommentReplieByID($id) {
        return DB::table("comment_replies")->where("comment_id",'=',$id)->get();
    }
}
