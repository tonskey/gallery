<?php
use Illuminate\Http\Request;
// Route::get('/',function(){
//     return view('index');
// });
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
	Route::post('/p/{id}','PictureController@update');
	Route::post('/p','PictureController@store');
	Route::delete('/p/{id}','PictureController@destroy');

});
// Route::resource('/p', 'PictureController');
Route::get('/p/{id}','PictureController@show');
Route::get('/p','PictureController@index');
Route::any('{all}',function(){
	return view('index');
})->where(['all'=>'.*']);
