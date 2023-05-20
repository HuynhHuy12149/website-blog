<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthorController;

Route::prefix('author')->name('author.')->group(function(){
  Route::middleware(['guest:web'])->group(function(){
      Route::view('/login','back.pages.auth.login')->name('login');
      Route::view('/forgot-password','back.pages.auth.forgot')->name('forgot-password');
      Route::get('/password/reset/{token}',[AuthorController::class,'ResetForm'])->name('reset-form');
      Route::view('/register','back.pages.auth.register')->name('register');
      Route::get('/active-account-author/{email}/{token}', [AuthorController::class, 'active_account_author'])->name('active-account-author');
      // Route::get('/register', [BlogController::class, 'showRegisterForm'])->name('register');
      // Route::post('/register', [BlogController::class, 'register'])->name('register');
  });

  Route::middleware(['auth:web'])->group(function(){
      Route::get('/home',[AuthorController::class,'index'])->name('home');
      Route::get('/logout',[AuthorController::class,'logout'])->name('logout');
      Route::view('/profile','back.pages.profile')->name('profile');
      Route::post('/change-profile-picture',[AuthorController::class, 'changeProfilePicture'])->name('change-profile-picture');
      
     
      Route::view('/categories','back.pages.categories')->name('categories');

      // comment
      Route::view('/comments','back.pages.comments')->name('comments');


       // chặn khi có tài khoản auhtor đăng nhập trỏ sang đia chỉ chức năng admin vẫn đươc
       Route::middleware(['isAdmin'])->group(function(){
        Route::view('/settings','back.pages.settings')->name('settings');
        Route::post('/change-blog-logo',[AuthorController::class,'changeBlogLogo'])->name('change-blog-logo');
        Route::post('/change-blog-favicon',[AuthorController::class,'changeBlogFavicon'])->name('change-blog-favicon');
        Route::view('/authors','back.pages.authors')->name('authors');
       

    });


      Route::prefix('posts')->name('posts.')->group(function(){
        Route::view('/add-post','back.pages.add-post')->name('add-post');
        Route::post('/create',[AuthorController::class, 'createPost'])->name('create');
        Route::view('/all','back.pages.all_posts')->name('all_posts');
        Route::get('/edit-post',[AuthorController::class,'editPost'])->name('edit-post');
        Route::post('/update-post',[AuthorController::class,'updatePost'])->name('update-post');

        // duyệt bài post
        Route::view('/all-posts-active','back.pages.posts_active')->name('all_posts_active');
        // cập nhật nội dung của admin và author và dùng để duyệt bài cho người duyệt bài
        Route::get('/active-post',[AuthorController::class,'activePost'])->name('active-post');
        Route::post('/update-post-active',[AuthorController::class,'updatePostActive'])->name('update-post-active');
        // admin dùng để duyệt bài
        Route::post('/update-status-post-active',[AuthorController::class,'updateStatusPostActive'])->name('update-status-post-actives');
        // phản hồi bài viết
        Route::post('/feedback-post',[AuthorController::class,'feedbackPost'])->name('feedback-post');

        // bài viết cần chỉnh sửa
        Route::view('/all-posts-refuse','back.pages.all_post_refuse')->name('all_posts_refuse');
        Route::post('/update-post-refuse',[AuthorController::class,'updatePostRefuse'])->name('update-post-refuse');
        Route::get('/refuse-post',[AuthorController::class,'refusePost'])->name('refuse-post');
        // hiển thị bài viết của admin
        Route::view('/my-all-posts','back.pages.my_posts')->name('my_posts');
      });
  });
});
