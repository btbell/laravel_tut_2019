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

Route::get('/test', function() {return 'Goodbye!'; });

Route::get('/rooms/{roomType?}', 'ShowRoomsController');

Route::resource('bookings', 'BookingController');

// Line 26 does all of the next severn routes!!!
//Route::get('/bookings', 'BookingController@index');
//Route::get('/bookings/create', 'BookingController@create');
//Route::post('/bookings', 'BookingController@store');
//Route::get('/bookings/{booking}', 'BookingController@show');
//Route::get('/bookings/{booking}/edit', 'BookingController@edit');
//Route::put('/bookings/{booking}', 'BookingController@update');
//Route::delete('/bookings/{booking}', 'BookingController@destroy');