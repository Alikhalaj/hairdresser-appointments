<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/services', 'ServiceController@index');
Route::get('/service/{service}', 'ServiceController@show');
Route::get('/barbers/{barbers}', 'BarberController@index');
Route::get('/appointments', 'AppointmentController@index');
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/service', 'ServiceController@store');
    Route::post('/barber', 'BarberController@store');
    Route::get('/barber/{barber}', 'BarberController@show');
    Route::post('/appointment', 'AppointmentController@store');
    Route::post('/appointment/lastTime', 'AppointmentController@lastTime');
    Route::get('/appointment/{appointment}', 'AppointmentController@show');
});
Route::group(['middleware' => ['sessions']], function () {
    Route::post('/sendOneTimeCode', 'UserController@send');
    Route::post('/login', 'UserController@loginRegister');
});
