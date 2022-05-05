<?php

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

use App\Http\Controllers\PostController;

load_route('installer');
load_route('website');

Route::post('additional/services', 'ServiceController@getAdditionalServicesByServiceId')
    ->name('additional_services_by_service_id');

Route::get('writer/apply', 'ApplicantController@create')
    ->name('writer_application_page');

Route::post('writer/apply', 'ApplicantController@store')
    ->name('store_writer_application');

Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');
Auth::routes(['verify' => true]);

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');
Route::get('post/add',[PostController::class, 'add'])->middleware('auth')->name('post.add');
Route::post('post/add_blog',[PostController::class, 'storeBlog'])->name('post.storeBlog');
Route::get('post/edit_my_post/{id}',[PostController::class, 'edit_my_post'])->name('post.edit_my_post');
Route::post('post/edit_my_post/{id}',[PostController::class, 'update_my_post'])->name('post.update_my_post');
Route::delete('my_post/trash/{id}',[PostController::class, 'trash_my_post'])->middleware('auth')->name('post.trash_my_post');

// Authenticated Users
Route::group(['middleware' => ['auth', 'verified']], function () {

    // Generic Routes (Admin and Staffs, both)
    load_route('generic');

    // For Admin Only
    Route::group(['middleware' => ['role:admin']], function () {
        load_route('admin');

    });
    // End of Admin only

    // For Staff Only
    Route::group(['middleware' => ['role:staff']], function () {
        load_route('staff');
    });
    // End of Staff Only


    // Admin and staff
    Route::group(['middleware' => ['role:admin|staff']], function () {

        Route::get('tasks', 'TaskController@index')->name('tasks_list');
        Route::post('/tasks/datatable/', 'TaskController@datatable')->name('tasks_datatable');
        Route::post('task/submit/{order}', 'TaskController@submit_work')->name('submit_work');
        Route::post('task/start/{order}', 'TaskController@start_working')->name('start_working');

    });
    // End of Admin and staff
    Route::get('/clear', function(){
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    });

    Route::post('sendmail','HomeController@sendmail')->name('sendmail');
});
