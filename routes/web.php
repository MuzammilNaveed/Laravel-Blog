<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\postsControllers;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\siteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\WidgetsController;
use App\Http\Controllers\SectionController;



    Route::get('/', [siteController::class,'userHomePage']);

    Route::get('category/{slug}',[siteController::class,'showCategory']);
    Route::get('post/{slug}',[siteController::class,'showSinglePost']);


    Route::get('/login',[siteController::class,'index'])->name('login');

    Route::post('/login_user',[HomeController::class,'UserLogin']);
    Route::get('/logout',[HomeController::class,'logout'])->name('logout.user');

    Route::get('/contact_us',[siteController::class,'staticPages']);
    Route::get('/about_us',[siteController::class,'staticPages']);

    // post comment
    Route::post('/post_comment',[siteController::class, 'postComment']);
    Route::post('/get_all_comment',[siteController::class, 'getAllComments']);
    Route::post('/comment_reply',[siteController::class, 'postCommentReply']);

    // authour
    Route::get('/author/{id}', [siteController::class, 'viewAuthorPage']);

    Route::post('/search_post', [siteController::class, 'searchPosts']);
    Route::get('/tag/{slug}', [siteController::class, 'showTagPage']);

    Route::post('/newsletter-subscription', [siteController::class, 'saveNewsletter']);
    Route::post('/save-contacts', [siteController::class, 'saveContacts']);

    Route::post('/save-newsletters', [siteController::class, 'saveNewsletters']);

Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', [HomeController::class, 'dashboard'])->name('home');

    // category
    Route::get('/get_categories', [CategoryController::class, 'getCategories'])->name('adminCategory.get');
    
    // tags
    Route::get('/get_tags', [TagsController::class, 'getTags'])->name("getTags");

    // section
    Route::get('/get_sections', [SectionController::class, 'getSections'])->name("getSections");

    // posts crud
    Route::get('/get_posts', [postsControllers::class, 'getPosts'])->name("posts.get");
    Route::post('/upload_post_imgs', [postsControllers::class, 'uploadPostImages']);
    Route::post('/delete_post_imgs', [postsControllers::class, 'deletePostImages']);

    // users
    Route::get('/get_users',[UserController::class, 'getUsers'])->name('getUsers');
    Route::get('/profile/{id}',[UserController::class, 'profile'])->name('user.profile');

    // users
    Route::get('/get_menus',[MenuController::class, 'getMenus'])->name('getMenus');

    Route::resources([
        'category' => CategoryController::class,
        'tag' => TagsController::class,
        'section' => SectionController::class,
        'posts' => postsControllers::class,
        'user' => UserController::class,
        'menu' => MenuController::class,
    ]);

    // menu & menu items
    // Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    // Route::get('/add-menu/{id?}', [MenuController::class, 'addMenu']);
    // Route::post('/update-menu', [MenuController::class, 'updateMenu']);
    // Route::post('/insert-menu', [MenuController::class, 'insertMenu']);

    Route::get('/edit-menu/{id}', [MenuController::class, 'editMenu']);
    Route::get('/menu-item/{id}', [MenuController::class, 'menuItemPage']);
    Route::post('/insert-menu-items', [MenuController::class, 'insertMenuItems']);
    Route::get('/edit-menu-item/{item_id}/{menu_id}', [MenuController::class, 'editMenuItemPage']);
    Route::post('/update-menu-item', [MenuController::class, 'updateMenuItem']);

    Route::get('/delete-menu-item/{id}', [MenuController::class, 'deleteMenuItem']);

    Route::post('/update-menu-item-position',[MenuController::class, 'updateMenuItemPostion']);
    
    
    // comments
    Route::get('/comments', [postsControllers::class, 'comments'])->name('comments.index');
    Route::get('/getComments', [postsControllers::class, 'getComments']);
    Route::get('/get_replie_by_id/{id}', [postsControllers::class, 'getCommentReplieByID']);
    Route::post('/approve_comment', [postsControllers::class, 'approveComment']);
    Route::post('/approve_comment_reply', [postsControllers::class, 'approveCommentReply']);

    Route::post('/comment_details', [postsControllers::class, 'commentDetails']);
    Route::get('/comment/{id}/{type}', [postsControllers::class, 'viewComment']);



    // settings
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/change_password', [SettingController::class, 'changePassword']);
    Route::post('/save_setting', [SettingController::class, 'saveSetting']);
    Route::post('/update_profile', [SettingController::class, 'updateProfile']);

    // contacts
    Route::get('/get_contacts', [SettingController::class, 'getAllContacts']);
    Route::get('/view_contacts/{id}', [SettingController::class, 'viewContact']);

    // feature
    Route::get('/feature', [FeatureController::class, 'index'])->name('feature.index');
    Route::post('/add_features', [FeatureController::class, 'store']);
    Route::get('/get_all_features', [FeatureController::class, 'getFeatures']);
    Route::get('/get_features_by_id/{id}', [FeatureController::class, 'getFeaturesByID']);
    Route::post('/update_feature', [FeatureController::class, 'update']);


    // admin pages
    Route::get('/visitors', [adminController::class, 'index'])->name('visitor.index');
    Route::get('/get_usrr_info', [adminController::class, 'getUserInfo']);


    // pages
    Route::get('/manage_pages', [PageController::class, 'managePages'])->name('pages.index');
    Route::get('/add_page', [PageController::class, 'addPages']);
    Route::post('/insert_page_data', [PageController::class, 'insertPageData']);
    Route::get('/edit_page/{slug}', [PageController::class, 'editPage']);
    Route::post('/save_edit_page', [PageController::class, 'saveEditPage']);


    // contact
    Route::get('/manage_contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/save_contact', [PageController::class, 'saveContact']);
    Route::get('/edit_contact/{id}', [PageController::class, 'editContact']);

    // newsletter
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('/get_all_newsletter', [NewsletterController::class, 'get_all_newletters']);

    
    // widgets
    Route::get('/manage_widgets', [WidgetsController::class, 'index'])->name('widgets.index');
    Route::post('/save-widget', [WidgetsController::class, 'saveWidget']);
    Route::get('/get-widget', [WidgetsController::class, 'showAllWidget']);
    Route::post('/delete-widget', [WidgetsController::class, 'deleteWidget']);
    
});

