<?php

Route::get('/resize', 'ToolController@index');
Route::get('/fixed', 'ToolController@fixedInvoice');
Route::get('/photo', 'ToolController@readImagesProducts');
Route::get('/imagebanner', 'ToolController@readImagesBanner');
Route::get('/imagecategory', 'ToolController@readImagesCategory');
Route::get('/imagesubcategory', 'ToolController@readImagesSubCategory');
Route::get('/excelcategory', 'ToolController@excelCategory');
Route::get('/exceldescription', 'ToolController@excelDescription');
Route::get('/exceltitle', 'ToolController@excelTitle');



