<?php

use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;

Route::post('dashboard/statistics', 'DashboardController@statistics')
	->name('dashboard_statistics');

Route::get('/orders', 'OrderController@index')
	->name('orders_list');

Route::get('orders/{order}/follow', 'OrderController@follow')
	->name('orders_follow');

Route::get('orders/{order}/unfollow', 'OrderController@unfollow')
	->name('orders_unfollow');

Route::get('orders/{order}/archive', 'OrderController@archive')
	->name('orders_archive');

Route::get('orders/{order}/unarchive', 'OrderController@unarchive')
	->name('orders_unarchive');


Route::post('/datatable/orders', 'OrderController@datatable')
	->name('orders_datatable');

Route::post('orders/{order}/status/change', 'OrderController@change_status')
	->name('order_change_status');

Route::post('task/assign/{order}', 'TaskController@assign_task')
	->name('assign_task');

	Route::get('orders/{order}/destroy', 'OrderController@destroy')
	->name('orders_destroy');


Route::get('/report/wallet/balance', 'ReportController@totalWalletBlance')
	->name('total_wallet_balance');

Route::get('/report/statement/income', 'ReportController@income_statement')
	->name('income_statement');

Route::post('/report/graph/income', 'ReportController@income_graph')
	->name('income_graph');

Route::get('/activity/log', 'ReportController@activity_log')
	->name('activity_log');

Route::post('/activity/log', 'ReportController@datatable_activity_log')
	->name('datatable_activity_log');

Route::get('/activity/log/delete', 'ReportController@destroy_activity')
	->name('activity_log_delete');


Route::prefix('users')->group(function () {

	Route::get('/', 'UserController@index')
		->name('users_list');

	Route::post('/paginate', 'UserController@paginate')
		->name('datatable_users');

	Route::get('/invitation', 'UserController@invitation')
		->name('user_invitation');

	Route::post('/invitation', 'UserController@send_invitation')
		->name('send_invitation');

	Route::get('/{user}/edit', 'UserController@edit')
		->name('users_edit')
		->where('user', '[0-9]+');

	Route::get('/{user}', 'UserController@show')
		->name('user_profile')
		->where('user', '[0-9]+');

	Route::post('/{user}/photo/change', 'UserController@change_photo')
		->name('users_change_photo')
		->where('user', '[0-9]+');

	Route::patch('/{user}', 'UserController@update')
		->name('users_update')
		->where('user', '[0-9]+');

	Route::delete('/{user}/delete', 'UserController@destroy')
		->name('users_destroy')
		->where('user', '[0-9]+');
});

Route::prefix('bills')->group(function () {

	Route::get('/', 'BillController@index')
		->name('bills_list');

	Route::post('/paginate', 'BillController@datatable')
		->name('datatable_bills');

	Route::get('/{bill}', 'BillController@show')
		->name('bills_show');

	Route::post('/{bill}/status/change/paid', 'BillController@mark_as_paid')
		->name('bill_mark_as_paid');

	Route::post('/{bill}/status/change/unpaid', 'BillController@mark_as_unpaid')
		->name('bill_mark_as_unpaid');
});

Route::prefix('settings')->group(function () {

	Route::get('/cache', 'SettingsController@clear_cache_page')
		->name('clear_cache_page');

	Route::post('/cache', 'SettingsController@clear_cache')
		->name('post_clear_cache');

	Route::get('/', 'SettingsController@general_information')
		->name('settings_main_page');

	Route::patch('/', 'SettingsController@update_general_information')
		->name('patch_general_information');

	Route::get('email', 'SettingsController@email')
		->name('settings_email_page');

	Route::patch('email/update', 'SettingsController@update_email')
		->name('patch_settings_email');

	Route::get('/email/test', 'SettingsController@test_email')
		->name('send_test_email');

	Route::post('/email/test', 'SettingsController@send_test_email')
		->name('post_test_email');

	Route::get('google-analytics', 'SettingsController@google_analytics')
		->name('google_analytics');

	Route::patch('google-analytics', 'SettingsController@update_google_analytics')
		->name('patch_google_analytics');

	Route::get('seo', 'SettingsController@seo')
		->name('seo_page');

	Route::patch('seo', 'SettingsController@update_seo')
		->name('patch_seo');


	Route::get('/logo', 'SettingsController@logo_page')
		->name('settings_logo_page');

	Route::post('/logo', 'SettingsController@update_logo')
		->name('update_logo');


	Route::get('content/{slug}', 'SettingsController@content')
		->name('settings_edit_content');

	Route::patch('content/{slug}', 'SettingsController@update_content')
		->name('settings_update_content');

	Route::get('/homepage', 'SettingsController@homepage')
		->name('settings_homepage');

	Route::patch('/homepage', 'SettingsController@update_homepage')
		->name('patch_settings_homepage');

	Route::get('/currency', 'SettingsController@currency')
		->name('settings_currency_page');

	Route::patch('/currency', 'SettingsController@update_currency')
		->name('patch_settings_currency');

	Route::get('/staff', 'SettingsController@staff')
		->name('settings_staff_page');

	Route::patch('/staff', 'SettingsController@update_staff')
		->name('patch_settings_staff');

	Route::get('/social-links', 'SettingsController@social_links')
		->name('settings_social_links');

	Route::patch('/social-links', 'SettingsController@update_social_links')
		->name('patch_settings_social_links');

	Route::get('custom-script', 'SettingsController@website_custom_scripts')
	->name('custom_script_page');

	Route::patch('custom-script', 'SettingsController@update_website_custom_scripts')
	->name('patch_custom_script');

	Route::get('recruitment', 'SettingsController@recruitment')
	->name('settings_recruitment');

	Route::patch('recruitment', 'SettingsController@updateRecruitment')
	->name('patch_settings_recruitment');

	// Services
	Route::prefix('services')->group(function () {

		Route::get('/', 'ServiceController@index')
			->name('services_list');

		Route::post('/paginate', 'ServiceController@datatable')
			->name('datatable_services');

		Route::get('/create', 'ServiceController@create')
			->name('services_create');

		Route::post('/', 'ServiceController@store')
			->name('services_store');

		Route::get('/{service}/edit', 'ServiceController@edit')
			->name('services_edit')
			->where('service', '[0-9]+');

		Route::patch('/{service}/edit', 'ServiceController@update')
			->name('services_update');

		Route::get('/{service}', 'ServiceController@destroy')
			->name('services_delete')
			->where('service', '[0-9]+');

		// Additional Services
		Route::prefix('additional')->group(function () {

			Route::get('/', 'AdditionalServiceController@index')
				->name('additional_services_list');

			Route::post('/paginate', 'AdditionalServiceController@datatable')
				->name('datatable_additional_services');

			Route::get('/create', 'AdditionalServiceController@create')
				->name('additional_services_create');

			Route::post('/', 'AdditionalServiceController@store')
				->name('additional_services_store');

			Route::get('/{additional_service}/edit', 'AdditionalServiceController@edit')
				->name('additional_services_edit');

			Route::patch('/{additional_service}/edit', 'AdditionalServiceController@update')
				->name('additional_services_update')
				->where('additional_service', '[0-9]+');

			Route::get('/{additional_service}', 'AdditionalServiceController@destroy')
				->name('additional_services_delete')
				->where('additional_service', '[0-9]+');
		});
		// End of Additional Services

        // Service Categories
        Route::prefix('service_category')->group(function () {

            Route::get('/', 'ServiceCategoryController@index')
                ->name('service_category_list');

            Route::post('/paginate', 'ServiceCategoryController@datatable')
                ->name('datatable_service_category');

            Route::get('/create', 'ServiceCategoryController@create')
                ->name('service_category_create');

            Route::post('/', 'ServiceCategoryController@store')
                ->name('service_category_store');

            Route::get('/{service_category}/edit', 'ServiceCategoryController@edit')
                ->name('service_category_edit');

            Route::patch('/{service_category}/edit', 'ServiceCategoryController@update')
                ->name('service_category_update')
                ->where('service_category', '[0-9]+');

            Route::get('/{service_category}', 'ServiceCategoryController@destroy')
                ->name('service_category_delete')
                ->where('service_category', '[0-9]+');
        });


	});
	// End of Services


	// Urgencies
	Route::prefix('urgencies')->group(function () {

		Route::get('/', 'UrgencyController@index')
			->name('urgencies_list');

		Route::post('/paginate', 'UrgencyController@datatable')
			->name('datatable_urgencies');

		Route::get('/create', 'UrgencyController@create')
			->name('urgencies_create');

		Route::post('/', 'UrgencyController@store')
			->name('urgencies_store');

		Route::get('/{urgency}/edit', 'UrgencyController@edit')
			->name('urgencies_edit');

		Route::patch('/{urgency}/edit', 'UrgencyController@update')
			->name('urgencies_update');

		Route::get('/{urgency}', 'UrgencyController@destroy')
			->name('urgencies_delete');
	});
	// End of Services


	// Work Levels
	Route::prefix('work-levels')->group(function () {

		Route::get('/', 'WorkLevelController@index')
			->name('work_levels_list');

		Route::post('/paginate', 'WorkLevelController@datatable')
			->name('datatable_work_levels');

		Route::get('/create', 'WorkLevelController@create')
			->name('work_levels_create');

		Route::post('/create', 'WorkLevelController@store')
			->name('work_levels_store');

		Route::get('/{work_level}/edit', 'WorkLevelController@edit')
			->name('work_levels_edit');

		Route::patch('/{work_level}/edit', 'WorkLevelController@update')
			->name('work_levels_update');

		Route::get('/{work_level}', 'WorkLevelController@destroy')
			->name('work_levels_delete');
	});
	// End of Work Levels


	// Tags
	Route::prefix('tags')->group(function () {

		Route::get('/', 'TagController@index')
			->name('tags_list');

		Route::post('/paginate', 'TagController@datatable')
			->name('datatables_tags');

		Route::get('/create', 'TagController@create')
			->name('tags_create');

		Route::post('/', 'TagController@store')
			->name('tags_store');

		Route::get('/{tag}/edit', 'TagController@edit')
			->name('tags_edit');

		Route::patch('/{tag}/edit', 'TagController@update')
			->name('tags_update');

		Route::get('/{tag}', 'TagController@destroy')
			->name('tags_delete');
	});

	Route::get('system/update', 'SettingsController@updateSystemPage')
		->name('update_system_page');

	Route::post('system/update', 'SettingsController@updateSystem')
		->name('update_system');

	load_route('payment_settings');
});


Route::prefix('payments')->group(function () {

	Route::get('/', 'Payments\PaymentController@index')
		->name('payments_list');

	Route::post('/', 'Payments\PaymentController@datatable')
		->name('datatable_payments');

	Route::get('pending/approvals', 'Payments\PendingPaymentsController@index')
		->name('pending_payment_approvals');

	Route::post('pending/approval/paginate', 'Payments\PendingPaymentsController@datatable')
		->name('datatable_pending_payment_approval');

	Route::get('pending/approvals/{approvedPayment}/approve', 'Payments\PendingPaymentsController@approvePendingPayment')
		->name('pending_payment_approve');

	Route::get('pending/approvals/{disapprovedPayment}/disapprove', 'Payments\PendingPaymentsController@disapprovePendingPayment')
		->name('pending_payment_disapprove');

});

Route::prefix('wallet/transactions')->group(function () {

	Route::get('/', 'WalletTransactionController@index')
		->name('wallet_transactions');

	Route::post('/', 'WalletTransactionController@datatable')
		->name('datatable_wallet_transactions');

	Route::get('pending/approvals', 'Payments\PendingPaymentsController@index')
		->name('pending_payment_approvals');

	Route::post('pending/approval/paginate', 'Payments\PendingPaymentsController@datatable')
		->name('datatable_pending_payment_approval');

	Route::get('pending/approvals/{approvedPayment}/approve', 'Payments\PendingPaymentsController@approvePendingPayment')
		->name('pending_payment_approve');

	Route::get('pending/approvals/{disapprovedPayment}/disapprove', 'Payments\PendingPaymentsController@disapprovePendingPayment')
		->name('pending_payment_disapprove');
});


Route::prefix('job')->group(function () {

	Route::get('applicants', 'ApplicantController@index')
		->name('job_applicants');

	Route::post('applicannts', 'ApplicantController@datatable')
	->name('datatable_job_applicannts');

	Route::post('applicants/{applicant}/status/change', 'ApplicantController@changeStatus')
		->name('applicant_change_status')
		->where('applicant', '[0-9]+');

	Route::delete('applicants/{applicant}/delete', 'ApplicantController@destroy')
		->name('applicant_delete')
		->where('applicant', '[0-9]+');

	Route::post('applicants/{applicant}/invite', 'ApplicantController@inviteToJoin')
		->name('applicant_invite_to_join')
		->where('applicant', '[0-9]+');

	Route::get('applicants/{applicant}', 'ApplicantController@show')
		->name('job_applicant_profile')
		->where('applicant', '[0-9]+');

});

// Manage Categories
Route::get('categories', [PostCategoryController::class, 'index'])->name('post_categories');
Route::get('categories/create', [PostCategoryController::class, 'create'])->name('post_category.create');
Route::post('categories/create', [PostCategoryController::class, 'store'])->name('post_category.store');
Route::get('categories/edit/{id}', [PostCategoryController::class, 'edit'])->name('post_category.edit');
Route::post('categories/edit/{id}', [PostCategoryController::class, 'update'])->name('post_category.update');
Route::delete('categories/destroy/{id}',[PostCategoryController::class, 'destroy'])->name('post_category.destroy');

// Manage Tags
Route::get('tags', [PostTagController::class, 'index'])->name('post_tags');
Route::get('tags/create', [PostTagController::class, 'create'])->name('post_tag.create');
Route::post('tags/create', [PostTagController::class, 'store'])->name('post_tag.store');
Route::get('tags/edit/{id}', [PostTagController::class, 'edit'])->name('post_tag.edit');
Route::post('tags/edit/{id}', [PostTagController::class, 'update'])->name('post_tag.update');
Route::delete('tags/destroy/{id}',[PostTagController::class, 'destroy'])->name('post_tag.destroy');

// Manage Blog
Route::get('post',[PostController::class, 'index'])->name('posts');
Route::get('post/create',[PostController::class, 'create'])->name('post.create');
Route::post('post/create',[PostController::class, 'store'])->name('post.store');
Route::get('post/edit/{id}',[PostController::class, 'edit'])->name('post.edit');
Route::post('post/edit/{id}',[PostController::class, 'update'])->name('post.update');
Route::get('post/trash',[PostController::class, 'trash'])->name('post.trash');
Route::post('post/{id}/restore',[PostController::class, 'restore'])->name('post.restore');
Route::delete('post/trash/{id}',[PostController::class, 'destroy'])->name('post.destroy');
Route::delete('post/destroy/{id}',[PostController::class, 'deletePermanent'])->name('post.deletePermanent');
Route::delete('post/destroy/{id}',[PostController::class, 'deletePermanent'])->name('post.deletePermanent');
Route::post('post/datatable', [PostController::class, 'datatable'])
    ->name('post.datatable');

