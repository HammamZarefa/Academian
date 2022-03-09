<?php

Route::prefix('install')->group(function (){

    Route::get('/', 'SystemController@index');

    Route::get('/system-check', 'SystemController@index')
    ->name('installer_page');

    Route::get('/database', 'SystemController@database_information')
    ->name('run_installation_step_2_page');

    Route::post('/database', 'SystemController@setup_database_connection')
    ->name('run_installation_step_2');

    Route::get('/database/connected', 'SystemController@db_connected')
    ->name('db_connected');
    
    Route::post('/run', 'SystemController@run_page')
    ->name('run_installation_step_4_page');

    Route::post('/setup/db', 'SystemController@setup_database')
    ->name('run_installation_step_4');

    Route::get('/status', 'SystemController@installation_result')
    ->name('installation_result');

    Route::get('/failed', 'SystemController@installation_failed')
    ->name('installation_failed');

     Route::get('/download/{path}', 'SystemController@download')
     ->name('download_error_log');

});