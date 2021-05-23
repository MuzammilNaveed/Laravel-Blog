<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\postsControllers;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeatureController;



Route::get('/', [HomeController::class,'userHomePage']);

// Route::get('/', function () {
//     if (Auth::user()) {
//       return redirect()->intended('/dashboard');
//     } else {
//         // return redirect()->intended('/login');
//         return view("website.index");
//     }
// });





// Route::get('category', function () {
//     return view('website.category');
// })->name("cat.index");

    Route::get('category/{slug}',[HomeController::class,'showCategory']);
    Route::get('post/{slug}',[HomeController::class,'showSinglePost']);


    Route::get('/login',[HomeController::class,'index'])->name('login');
    // Auth::routes();

    Route::post('/login_user',[HomeController::class,'UserLogin']);
    Route::get('/logout',[HomeController::class,'logout'])->name('logout.user');



   // post comment
   Route::post('/post_comment',[postsControllers::class, 'postComment']);
   Route::post('/get_all_comment',[postsControllers::class, 'getAllComments']);
   Route::post('/comment_reply',[postsControllers::class, 'postCommentReply']);

 

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard.index');

    // category crud
    Route::resource('categories', categoryController::class);
    Route::get('/manage_categories', function() {
        return view('admin.category.category');
    })->name('category.index');

    // tags crud
    Route::resource('tags', TagsController::class);

    Route::get('/manage_tags', function() {
        return view('admin.tags.tag');
    })->name('tag.index');

    // posts crud
    Route::resource('posts', postsControllers::class);
    Route::get('/add_post', [postsControllers::class, 'addPostPage'])->name('add_post.index');
    Route::get('/edit_post/{id}', [postsControllers::class, 'editPostPage']);
    Route::get('/active_post/{id}', [postsControllers::class, 'activePost']);
    Route::post('/update_post', [postsControllers::class, 'updatePost']);

    Route::post('/upload_post_imgs', [postsControllers::class, 'uploadPostImages']);
    Route::post('/delete_post_imgs', [postsControllers::class, 'deletePostImages']);

    Route::get('/manage_post', function() { return view('admin.posts.post'); })->name('post.index');



    // roles crud
    Route::resource('roles', RoleController::class);
    Route::get('/manage_roles', [RoleController::class, 'manageRoles'])->name('role.index');


    // users crud
    Route::get('/manage_users',[HomeController::class, 'manageUserPage'])->name("user.index");
    Route::post('/create_users',[HomeController::class, 'createUser']);
    Route::get('/get_all_users',[HomeController::class, 'getAllUsers']);
    Route::post('/update_users',[HomeController::class, 'updateUser']);


    // comments
    Route::get('/comments', [postsControllers::class, 'comments'])->name('comments.index');
    Route::get('/getComments', [postsControllers::class, 'getComments']);
    Route::get('/get_replie_by_id/{id}', [postsControllers::class, 'getCommentReplieByID']);


    // settings
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/change_password', [SettingController::class, 'changePassword']);
    Route::post('/save_setting', [SettingController::class, 'saveSetting']);


    // feature
    Route::get('/feature', [FeatureController::class, 'index'])->name('feature.index');
    Route::post('/add_features', [FeatureController::class, 'store']);
    Route::get('/get_all_features', [FeatureController::class, 'getFeatures']);
    Route::get('/get_features_by_id/{id}', [FeatureController::class, 'getFeaturesByID']);
    Route::post('/update_feature', [FeatureController::class, 'update']);

 
});

