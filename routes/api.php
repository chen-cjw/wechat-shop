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
        // 添加收获地址
        $api->post('/user_address','UserAddressController@store')->name('api.user_address.store');
        // 收货地址
        $api->get('/user_address','UserAddressController@index')->name('api.user_address.index');
        // 修改收获地址
        $api->post('/user_address/{user_address}', 'UserAddressController@update')->name('user_addresses.update');
        $api->post('/user_address/{user_address}/destroy', 'UserAddressController@destroy')->name('user_addresses.destroy');

        // 分类
        $api->get('/category', 'CategoryController@index')->name('category.index');

    });
});
