<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

Route::resource('users', 'UsersController');
/* 上面的resource路由相当于下面定义的这么多路由
// 显示所有用户列表的页面
Route::get('/users', 'UsersController@index')->name('users.index');
// 显示用户个人信息的页面
Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// 显示创建用户的页面
Route::get('/users/create', 'UsersController@create')->name('users.create');
// 创建用户，接收用户填写的个人信息表单来创建用户
Route::post('/users', 'UsersController@store')->name('users.store');
// 显示编辑用户个人信息的页面
Route::get('/users/{users}/edit', 'UsersController@edit')->name('users.edit');
// 更新用户，接受用户填写的更新信息来修改用户信息
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
// 删除用户
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');
 */

// 显示用户登录页面
Route::get('login', 'SessionsController@create')->name('login');
// 创建新会话（完成用户登录动作）
Route::post('login', 'SessionsController@store')->name('login');
// 销毁会话（用户退出登录）
Route::get('logout', 'SessionsController@destroy')->name('logout');

// 显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// 密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 定义statuses模型的资源控制路由，并限定只接受创建和删除操作
//  HTTP请求：POST URL路由：/statuses 动作： StatusesController@store  处理创建微博的请求
//  HTTP请求：DELETE URL路由：/statuses 动作： StatusesController@destroy 处理删除微博的请求
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

//  HTTP请求：GET URL路由：/users/{user_id}/followings 动作： UsersController@followings  显示用户的关注人列表
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
//  HTTP请求：GET URL路由：/users/{user_id}/followers 动作： UsersController@followers   显示用户的粉丝列表
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');