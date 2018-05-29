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

Route::get('/', function () {
    // return redirect('admin');
});
Route::get('authimg','AuthimgController@index');
Route::get('study',function ()
{
  echo \Hash::make('superadmin');
});
Route::get('wechat/synimg','WxController@index');
