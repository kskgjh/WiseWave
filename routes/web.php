<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\bannerImgController;
use App\Http\Controllers\categoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\userController;
use App\Http\Controllers\variantController;
use App\Http\Middleware\someUser;
use Illuminate\Http\Request;

Route::prefix('/')->controller(Controller::class)->group(function (){
    Route::get('/register', 'renderForm')->name('register.render');
    Route::middleware(someUser::class)
            ->get('admin/register', 'adminForm')
            ->name('admin.register');
    Route::get('/', 'index')->name('index');
    Route::get('/logout', 'logout');
    Route::fallback('index');
});

Route::prefix('/user')
    ->controller(userController::class)
    ->group(function (){
        Route::post('/login', 'authenticate')->name('user.auth');
        Route::post("/register", 'submit')->name('user.register');
        Route::middleware(someUser::class)->post('/register/admin', 'registerAdmin')->name('admin.register.submit');
});

Route::prefix('/banner')
    ->controller(bannerImgController::class)
    ->group(function(){
        Route::get('/', 'all')->name('banner.all');
})  
    ->middleware('admin')
    ->group(function (){
        Route::post('/', 'save')->name('banner.save');
        Route::delete('/del/{id}', 'delete')->name('banner.delete');
});

Route::prefix('/admin')
    ->controller(adminController::class)
    ->middleware('admin')
    ->group(function (){
        Route::get('/', 'index')->name('admin.index');
});

Route::prefix('/product')
    ->controller(ProductController::class)
    ->group(function (){
        Route::get('/page/{id}', 'render')->name('product.render');
        Route::get('/{order?}', 'all')->name('product.all');
        Route::get('/find/{id}', 'find')->name('product.find');

})
    ->middleware('admin')
    ->group(function(){
        Route::delete('/del/{id}', 'delete')->name('product.delete');
        Route::put('/update', 'update')->name('product.update');
        Route::delete('/vol/del/{id}', 'deleteVol')->name('vol.delete');
        Route::post('/', 'add')->name('product.add');
});

Route::prefix('/variant')
    ->controller(variantController::class)
    ->group(function(){
        Route::get('/', 'all')->name('all.variant');
        Route::get('/{id}', 'find')->name('find.variant');

})  
    ->middleware('admin')
    ->group(function(){    
        Route::post('/{amount}', 'add')->name('add.variant');

});

Route::prefix('/category')
    ->controller(categoryController::class)
    ->group(function(){
        Route::get('/', 'all')->name('category.all');
        Route::get('/{id}', 'find')->name('category.find');
})
    ->middleware('admin')
    ->group(function(){
        Route::post('/', 'add')->name('category.add');
    });
