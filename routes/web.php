<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;


Route::get('/',   [HomeController::class, 'index'])->name('home');
Route::get('/filter-videos', [HomeController::class, 'filterVideos']);
Route::get('/play/{slug}', [HomeController::class, 'playVideo'])->name('playVideo');
Auth::routes();
Route::post('/reviews', [FeedbackController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{video_id}', [FeedbackController::class, 'index'])->name('reviews.index');
Route::get('/profile',   [HomeController::class, 'profile'])->name('profile');
Route::get('/user-videos',   [HomeController::class, 'userVideos'])->name('userVideos');
Route::get('/upload-video',   [HomeController::class, 'uploadVideo'])->name('uploadVideo');
Route::post('/upload-video',   [HomeController::class, 'uploadVideoSubmit'])->name('upload.video');
Route::post('/profile/update', [HomeController::class, 'editProfile'])->name('editProfile');
Route::get('/download-csv', [App\Http\Controllers\DataExportController::class, 'exportCsv']);
Route::get('/rating/download/{video}', [RatingController::class, 'download'])->name('download.rating');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('admin', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/setting', [AdminController::class, 'setting'])->name('setting');
    Route::post('/admin/edit_setting', [AdminController::class, 'editSetting'])->name('settings.edit');

    // category
    Route::resource('category', CategoryController::class);

    // videos
    Route::resource('videos', VideoController::class);

    //Users
    Route::resource('users', UserController::class);

    //Users
    Route::resource('admins', AdminController::class);

    Route::get('/users/block/{user_id}', [UserController::class, 'blockUser'])->name('users.block');
    Route::get('/users/unblock/{user_id}', [UserController::class, 'UnblockUser'])->name('users.unblock');

    Route::get('/admins/block/{user_id}', [AdminController::class, 'blockAdmin'])->name('admins.block');
    Route::get('/admins/unblock/{user_id}', [AdminController::class, 'UnblockAdmin'])->name('admins.unblock');


    Route::get('/video-comments', [VideoController::class, 'viewComments'])->name('comments.view');
});

