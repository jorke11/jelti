<?php

Route::resource('/user', 'Security\UserController');
Route::get('/user/getListPermission/{id}', 'Security\UserController@getPermission');
Route::put('/user/savePermission/{id}', 'Security\UserController@savePermission');

Route::resource('/role', 'Security\RoleController');
Route::put('/role/savePermission/{id}', 'Security\RoleController@savePermissionRole');

Route::get('/getPermissionRole/{id}', 'Security\RoleController@getPermissionRole');

Route::resource('/permission', 'Security\PermissionController');

Route::get('/api/listPermission', 'Security\PermissionController@getPermission');

Route::get('/permission/{id}/getMenu', ['uses' => 'Security\PermissionController@getMenu']);
Route::post('/user/uploadExcel', 'Security\UserController@storeExcel');
Route::put('/user', 'Security\UserController@store');
