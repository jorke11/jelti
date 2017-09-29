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


Route::get('overview/email', "Report\CronController@emailoverview");
Route::get('overview/emailbriefcaseclient', "Report\CronController@emailbriefcaseclient");
Route::get('overview/testnotificaction/{id}', "Report\CronController@notificacionBriefcaseClient");
