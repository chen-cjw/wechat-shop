<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array']
], function ($api) {
    // 授权
    $api->post('/auth','AuthController@store')->name('api.auth.store');

    $api->group(['middleware' => ['auth:api']], function ($api) {

        $api->get('/auth','AuthController@index')->name('api.auth.index');

        // 个人信息
        $api->get('/meShow','AuthController@meShow')->name('api.auth.meShow');
        // 退出
        $api->delete('/auth/current', 'AuthController@destroy')->name('api.auth.destroy');

        // 添加收获地址
        $api->post('/user_address','UserAddressController@store')->name('api.user_address.store');
        // 收货地址
        $api->get('/user_address','UserAddressController@index')->name('api.user_address.index');
        // 修改收获地址
        $api->put('/user_address/{user_address}', 'UserAddressController@update')->name('api.user_addresses.update');
        $api->delete('/user_address/{user_address}', 'UserAddressController@destroy')->name('api.user_addresses.destroy');
        // 默认选中地址
        $api->patch('/user_address/{user_address}', 'UserAddressController@select')->name('api.user_addresses.select');


        // 分类
        $api->get('/category', 'CategoryController@index')->name('api.category.index');
        // 商品
        $api->get('/category/{category_id}/product', 'ProductController@index')->name('api.product.index');
        // 商品详情
        $api->get('/product/{id}', 'ProductController@show')->name('api.product.show');

        // 购物车商品
        $api->get('/cart', 'CartController@index')->name('api.cart.index');
        // 添加购物车
        $api->post('/cart', 'CartController@store')->name('api.cart.store');
        // 移除购物车商品
        $api->delete('/cart/{id}', 'CartController@destroy')->name('api.cart.destroy');
        // 提交订单 OrdersController
        $api->get('/order', 'OrdersController@index')->name('api.order.index');
        $api->get('/order/{id}', 'OrdersController@show')->name('api.order.show');
        $api->post('/order', 'OrdersController@store')->name('api.order.store');

        // 取消
        $api->post('/order/{id}/close', 'OrdersController@close')->name('api.order.close');

        // 确认
        $api->post('/order/{id}/confirm', 'OrdersController@confirm')->name('api.order.confirm');


    });
});
