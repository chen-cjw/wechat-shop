<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/users', 'UsersController@index');
    //
//    $router->get('category', 'CategoryController@index');
    $router->resource('/category','CategoryController');
    $router->get('/product/collectIndex','ProductController@collectIndex');
    $router->post('/product/collect','ProductController@collect');
    $router->resource('/product','ProductController')->only(['store','index','create','show','update','edit']);
    $router->resource('/orders', 'OrdersController');
    $router->resource('/banners', 'BannerController');
    $router->post('/orders/{id}/confirm', 'OrdersController@confirm');

});
