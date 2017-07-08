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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'service/v1', 'middleware' => 'auth'], function() {
    
    // Message relate
    Route::post('/message', 'ApiMessageController@message');
    Route::get('/messagesInitial', 'ApiMessageController@getMessagesInitial');
    Route::get('/getUsers', 'ApiMessageController@findAllUsers');
    
    // Users
    Route::post('/addNewUser', 'ApiUserController@addNewUser');
    Route::post('/changeUserPassword', 'ApiUserController@changeUserPassword');
    Route::post('/toggleEnable', 'ApiUserController@toggleEnable');
});