<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authorization
Route::get('/login', ['as' => 'auth.login.form', 'uses' => 'Auth\SessionController@getLogin']);
Route::post('/login', ['as' => 'auth.login.attempt', 'uses' => 'Auth\SessionController@postLogin']);
Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\SessionController@getLogout']);

// Registration
Route::get('register', ['as' => 'auth.register.form', 'uses' => 'Auth\RegistrationController@getRegister']);
Route::post('register', ['as' => 'auth.register.attempt', 'uses' => 'Auth\RegistrationController@postRegister']);

// Activation
Route::get('activate/{code}', ['as' => 'auth.activation.attempt', 'uses' => 'Auth\RegistrationController@getActivate']);
Route::get('resend', ['as' => 'auth.activation.request', 'uses' => 'Auth\RegistrationController@getResend']);
Route::post('resend', ['as' => 'auth.activation.resend', 'uses' => 'Auth\RegistrationController@postResend']);

// Password Reset
Route::get('password/reset/{code}', ['as' => 'auth.password.reset.form', 'uses' => 'Auth\PasswordController@getReset']);
Route::post('password/reset/{code}', ['as' => 'auth.password.reset.attempt', 'uses' => 'Auth\PasswordController@postReset']);
Route::get('password/reset', ['as' => 'auth.password.request.form', 'uses' => 'Auth\PasswordController@getRequest']);
Route::post('password/reset', ['as' => 'auth.password.request.attempt', 'uses' => 'Auth\PasswordController@postRequest']);

// Users
Route::resource('users', 'UserController');

// Roles
Route::resource('roles', 'RoleController');

// Dashboard
Route::get('dashboard', ['as' => 'dashboard', 'uses' => function() {
    return view('centaur.dashboard');
}]);


Route::post('sendmessage', ['as'=>'chat.message', 'uses'=>'ChatController@send']);
Route::get('homepage', ['as'=>'chat.home', 'uses'=>'ChatController@index']);
Route::post('open/private', ['as'=>'chat.open', 'uses'=>'ChatController@openChat']);
Route::post('getallchats', ['as'=>'chat.all', 'uses'=>'ChatController@allChats']);

Route::post('uploadattachment', ['as'=>'chat.upload', 'uses'=>'ChatController@upload']);


// IO Test
Route::get('fire', function() {
  event(new App\Events\EventName());
  return "event fired";
});

Route::get('test', function() {
  return view('test');
});
