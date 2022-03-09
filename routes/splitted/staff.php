<?php

Route::prefix('browse-work')->group(function () {  

	Route::get('/', 'TaskController@browse_work')
	->name('browse_work');

	Route::post('/', 'TaskController@datatable_browse_work')
	->name('browse_work_datatable');

	Route::post('details/{order}', 'TaskController@self_assign_task')
	->name('accept_work');

});


Route::prefix('payments/requests')->group(function () {  

	Route::get('/', 'BillController@my_requests_for_payment')
	->name('my_requests_for_payment');

	Route::post('/', 'BillController@datatable_my_requests_for_payment')
	->name('datatable_my_requests_for_payment');

	Route::get('make', 'BillController@create')
	->name('request_for_payment');

	Route::post('make', 'BillController@store')
	->name('post_request_for_payment');

	Route::get('/details/{bill}', 'BillController@show')
	->name('my_requests_bills_show')
	->where('bill', '[0-9]+');

});