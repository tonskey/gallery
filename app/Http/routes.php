<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;
Route::get('/',function(){
    return view('index');
});
Route::post('/register', [
        'uses' => 'Auth\AuthController@register',
]);
Route::post('/signin', [
    'uses' => 'Auth\AuthController@signin',
]);
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/user', [
       'uses' => 'UserController@index',
    ]);
});
Route::post('/p/{id}','PictureController@update');
Route::resource('/p', 'PictureController');
Route::any('{all}',function(){
	return view('index');
})->where(['all'=>'.*']);