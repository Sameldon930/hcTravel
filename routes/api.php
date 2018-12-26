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

Route::any('v1', ['middleware'=>'api','uses'=>'ApiController@index']);
Route::any('wxoauth', ['middleware'=>'api','uses'=>'WeChatController@oauth']);

Route::any('v2', ['middleware'=>'api','uses'=>'ApiController@new_list']);