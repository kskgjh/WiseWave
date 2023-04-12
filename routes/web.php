<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\bannerImgController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\userController;


Route::prefix('/')->controller(Controller::class)->group(function (){
    Route::get('/register', 'renderForm')->name('register.render');
    Route::get('admin/register', 'adminForm')->name('admin.register');
    Route::get('/', 'index')->name('index');
    Route::get('/logout', 'logout');
    Route::fallback('index');
});

Route::prefix('/user')
    ->controller(userController::class)
    ->group(function (){
        Route::post('/login', 'authenticate')->name('user.auth');
        Route::post("/register", 'submit')->name('user.register');
        Route::post('/register/admin', 'registerAdmin')->name('admin.register.submit');


});

Route::prefix('/banner')
    ->controller(bannerImgController::class)
    ->middleware('admin')
    ->group(function(){
        Route::post('/', 'save')->name('banner.save');
        Route::get('/', 'all')->name('banner.all');
        Route::delete('/del', 'delete')->name('banner.delete');
    });

Route::prefix('/admin')
    ->controller(adminController::class)
    ->middleware('admin')
    ->group(function (){
        Route::get('/', 'index')->name('admin.index');
});

Route::prefix('/product')
    ->controller(ProductController::class)
    ->middleware('admin')
    ->group(function (){
        Route::post('/variant/{amount}', 'addVariant')->name('product.add.variant');
        Route::get('/variant/{id}', 'getVariant')->name('product.get.variant');

        Route::post('/category', 'addCategory')->name('product.add.category');
        Route::get('/category', 'allCategories')->name('product.all.category');

        Route::get('/all', 'all')->name('product.all');
        Route::delete('/del/{id}', 'delete')->name('product.delete');
});