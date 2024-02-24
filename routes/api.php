<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\NotificationController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public Routes

Route::post('/register', [LoginController::class, 'register'])->name('auth.register');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');


//Protected Routes

// Route::get('/user', [UserController::class, 'getUserDetails'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin'], function () {

    Route::get('/logout', [UserController::class, 'logoutUser'])->name('logout');
    Route::get('/user', [UserController::class, 'getUserDetails'])->name('auth.user');
    
    Route::get('/users', [UserController::class, 'index'])->name('all_users');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('show_user');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('update_user');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('delete_user');    

    //articles all routes
    Route::resource('articles', ArticleController::class); 
    
    //tags all routes
    Route::resource('tags', TagController::class);

    //categories all routes
    Route::resource('categories', CategoryController::class);

    //collections all routes
    Route::resource('collections', CollectionController::class);

    //enquiries all routes
    Route::resource('enquiries', EnquiryController::class);

    //comments all routes
    Route::resource('comments', CommentController::class);

    //albums all routes
    Route::resource('albums', AlbumController::class);

    //galleries all routes
    Route::resource('galleries', GalleryController::class);

    //file_uploads all routes
    Route::resource('file_uploads', FileUploadController::class);

    //roles all routes
    Route::resource('roles', RoleController::class);

    //permissions all routes
    Route::resource('permissions', PermissionController::class);

    //faqs all routes
    Route::resource('faqs', FaqController::class);

    //addresses all routes
    Route::resource('addresses', AddressController::class);

    //user_profiles all routes
    Route::resource('user_profiles', UserProfileController::class);

     //notifications all routes
     Route::resource('notifications', NotificationController::class);
	    
});



