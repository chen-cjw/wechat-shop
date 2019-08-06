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
    $router->resource('/product','ProductController');
    $router->resource('/orders', 'OrdersController');
    $router->post('/orders/{id}/confirm', 'OrdersController@confirm');

});
