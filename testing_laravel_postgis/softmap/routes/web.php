<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'App\Http\Controllers\LocationController@index');
Route::get('/new', 'App\Http\Controllers\LocationController@create');


Route::get('/form', 'App\Http\Controllers\UpperController@form');
Route::post('/post', 'App\Http\Controllers\UpperController@post');
//Route::get('/create', 'App\Http\Controllers\UpperController@create');
Route::post('/create', 'App\Http\Controllers\UpperController@create');
Route::get('/add', 'App\Http\Controllers\UpperController@add');

Route::get('/leaflet', 'App\Http\Controllers\LocationController@leaflet');
Route::get('/openlayers', 'App\Http\Controllers\LocationController@openlayers');

Route::get('/geojson', 'App\Http\Controllers\LocationController@geojson');


