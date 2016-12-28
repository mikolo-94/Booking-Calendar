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


Route::get('/', [
    'uses' => 'CalendarController@showEvents',
    'as' => 'admin'
]);

Route::post('/eventupdate', [
    'uses' => 'CalendarController@eventUpdate',
    'as' => 'eventupdate'
]);

Route::post('/bulkupdate', [
    'uses' => 'CalendarController@bulkUpdate',
    'as' => 'bulkupdate'
]);
