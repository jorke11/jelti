<?php

Route::get('blog', "Blog\BlogController@index");
Route::get('listProducts', "Blog\BlogController@listProducts");
Route::get('blog/{slug}', "Blog\BlogController@getDetail");
Route::post('blog/{slug}', "Blog\BlogController@newComment");
Route::get('admin/blog', ["as" => "admin.blog", "uses" => "Blog\BlogController@getAllPost"]);

Route::get('admin/blog/category', ["uses" => "Blog\CategoryController@index"]);
Route::post('admin/blog/category', ["uses" => "Blog\CategoryController@store"]);

Route::get('admin/blog/{id}/edit', "Blog\BlogController@show");
Route::put('blog/update/{id}', ["as" => 'blog.update', "uses" => "Blog\BlogController@update"]);
Route::get('admin/blog/{id}/delete', "Blog\BlogController@delete");
Route::delete('blog/destroy', ["as" => "admin.blog.destroy", "uses" => "Blog\BlogController@destroy"]);
Route::get('admin/blog/create', "Blog\BlogController@create");
Route::post('admin/blog/store', ["as" => "admin.blog.store", "uses" => "Blog\BlogController@store"]);
Route::post('newComment', "Blog\BlogController@newComment");

Route::get('/api/listCategoryBlog', function() {
    return Datatables::queryBuilder(DB::table("vcategories_blog")->orderBy("order", "asc"))->make(true);
});
