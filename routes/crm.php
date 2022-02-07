<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::group(['middleware' => ['auth:crm']], function () {
    Route::get('test',function(){

    });
    Route::post('/req','LoginController@user');
    Route::post('/logout', 'LoginController@logout');
});


Route::post('/register', 'RegisterController@authentication');
Route::post('/login', 'LoginController@authentication');
