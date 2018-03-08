<?php

Route::resource('/activity', 'Crm\ActivityController');

Route::get('/api/listActivity', function() {
    return Datatables::eloquent(App\Models\Crm\Activity::query())->make(true);
});


Route::resource('/ticket', 'Administration\TicketController');
Route::post('/ticket/addComment', 'Crm\TicketController@addComment');


Route::get('/api/listTicket', function() {
    return Datatables::queryBuilder(
                    DB::table('tickets')
            )->make(true);
});

Route::resource('/fulfillment', 'Crm\FulfillmentController');
Route::get('/fulfillment/getInfo/{year}/{month}', 'Crm\FulfillmentController@getInfo');
Route::get('/fulfillment/getMax/{id}', 'Crm\FulfillmentController@getMax');
Route::get('/fulfillment/getSales/{id}', 'Crm\FulfillmentController@getSales');
Route::post('/fulfillment/addTarjet', 'Crm\FulfillmentController@setTarjet');
Route::put('/fulfillment/editTarjet/{id}', 'Crm\FulfillmentController@updateTarjet');

Route::get('/fulfillment/getDetail/{id}', 'Crm\FulfillmentController@getDetail');

Route::put('/fulfillment/updateDetail/{id}', 'Crm\FulfillmentController@updateDetail');
Route::post('/fulfillment/addCommercial', 'Crm\FulfillmentController@store');
