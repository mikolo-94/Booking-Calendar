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
/*
Route::get('/', [
    'uses' => 'CalendarController@showView'
]);
*/
/*
$uses = 'CalendarController@showView';
if(request()->ajax())
{
    $uses = 'CalendarController@showEvents';
}

Route::get('/', array(
    'as'=>'admin'
,'uses'=> $uses
));
*/
Route::post('/eventupdate', [
    'uses' => 'CalendarController@eventUpdate',
    'as' => 'eventupdate'
]);

Route::post('/bulkupdate', [
    'uses' => 'CalendarController@bulkUpdate',
    'as' => 'bulkupdate'
]);


/*
$uses = 'EventController@showView';
if($request->wantsJson())
{
    $uses = 'EventController@showEvents';
}

Route::get('/', array(
    'as'=>'home'
,'uses'=> $uses
));*/