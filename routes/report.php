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

use App\Models;
use Models\Administration\Categories;

Route::get('comparative', "Report\ComparativeController@index");
Route::get('comparative', "Report\ComparativeController@index");
Route::get('comparatives/salesClient', "Report\ComparativeController@salesClient");