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


Route::any('/login',"IndexController@login");
// Route::get('/crypt',"IndexController@crypt");
Route::get('/logout',"IndexController@logout");

#大小写要与kernel中一致
Route::group(['middleware' =>['web','login']],function(){
	Route::get('/', "IndexController@index");
	Route::any('/add',"IndexController@add");
	Route::any('/update/{id}',"IndexController@update");
	Route::get('/delete/{id}',"IndexController@delete"); #这里id不算post的参数
	Route::get('/download/{id}',"IndexController@download");
	Route::get('/recycle',"IndexController@recycle");
	Route::get('/rollback/{id}',"IndexController@rollback");
	Route::any('/uac',"IndexController@uac");
	Route::get('/deleteUser/{id}',"IndexController@deleteUser");
	Route::get('/rollbackUser/{id}',"IndexController@rollbackUser");
	Route::post('/addUser',"IndexController@addUser");
});