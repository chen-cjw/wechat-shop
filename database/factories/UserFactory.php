<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
//        'openid','nickname','sex','language','city','province','country','headimgurl','unionid'
$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'nickname' => $faker->name,
        'openid' => 'oTpPj5HfdauThkOX4tSUbz5vajGY',
        'sex' => 0,
        'avatar' => 'http://b-ssl.duitang.com/uploads/item/201805/13/20180513224039_tgfwu.png',
    ];
});
