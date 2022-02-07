<?php

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/services','ServiceController@index');
Route::get('/service/{service}','ServiceController@show');
Route::post('/service','ServiceController@store');

// Route::get('/sendEmail',function(){
//     $detail = [
//         'subject'=>"این یک پیام تستی است",
//         'title' => 'تبریک',
//         'body' => '  شما مقداری پول برنده شده اید لطفا شماره کارت و رمز دومتنو برای ما بفرستید هر کی نفرسته خره !!!! *****))))'
//     ];
//     Mail::to('akh30002@gmail.com')->send(new App\Mail\TestMail($detail));
//     echo "Dsfsd";
// });

// Route::get('/queue',function(){
//     dispatch(function(){
//         logger("this test loger");
//         return "Finished";
//     });
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
