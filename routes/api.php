<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => ['auth:api']], function () {
    // service
    Route::get('/services', 'ServiceController@index');
    Route::post('/service', 'ServiceController@store');
    Route::get('/service/{service}', 'ServiceController@show');
    // barber
    Route::post('/barber', 'BarberController@store');
    Route::post('/barber/edit', 'BarberController@edit');
    Route::get('/barbers/{barbers}', 'BarberController@index');
    Route::get('/barber/{barber}', 'BarberController@show');
    Route::get('/barber', 'BarberController@profile');
    Route::post('/search', 'BarberController@search');
    // advertising
    Route::get('/advertising', 'AdvertisingController@index');
    Route::post('/advertising', 'AdvertisingController@create');
    // user
    Route::get('/user', 'UserController@index');
    Route::post('/user', 'UserController@edit');
    // appointment
    Route::get('/appointments/barber/{barber}', 'AppointmentController@index');
    Route::post('/appointment', 'AppointmentController@store');
    Route::post('/appointment/lastTime', 'AppointmentController@lastTime');
    Route::get('/appointment/{appointment}', 'AppointmentController@show');
});
Route::post('/sendOneTimeCode', 'UserController@send');
Route::post('/login', 'UserController@loginRegister');
