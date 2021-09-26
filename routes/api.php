<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/services', 'ServiceController@index');
    Route::get('/barbers/search', 'BarberController@search');
    Route::get('/service/{service}', 'ServiceController@show');
    Route::get('/barbers/{barbers}', 'BarberController@index');
    Route::get('/advertising', 'AdvertisingController@index');
    Route::get('/appointments', 'AppointmentController@index');
    Route::get('/user', 'UserController@index');
    Route::post('/user', 'UserController@edit');
    Route::post('/service', 'ServiceController@store');
    Route::post('/barber', 'BarberController@store');
    Route::get('/barber', 'BarberController@show');
    Route::post('/appointment', 'AppointmentController@store');
    Route::post('/appointment/lastTime', 'AppointmentController@lastTime');
    Route::get('/appointment/{appointment}', 'AppointmentController@show');
});
Route::group(['middleware' => ['sessions']], function () {
    Route::post('/sendOneTimeCode', 'UserController@send');
    Route::post('/login', 'UserController@loginRegister');
});
