<?php

Route::get('blog', "Blog\BlogController@index");
Route::get('listProducts', "Blog\BlogController@listProducts");
Route::get('blog/{id}', "Blog\BlogController@getDetail");