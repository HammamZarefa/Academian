<?php

Route::get('/dashboard', 'DashboardController@index')
    ->name('dashboard');

Route::post('cart/add', 'CartController@storeOrderInSession')
    ->name('add_to_cart');


// Handle File Uploads and Downloads
Route::prefix('attachments')->group(function () {

    Route::get('download', 'AttachmentController@download')
        ->name('download_attachment');

    Route::post('upload', 'AttachmentController@upload')
        ->name('order_upload_attachment');

    Route::delete('upload', 'AttachmentController@remove');
});
// End of Handle File Uploads and Downloads




// Checkout
Route::prefix('checkout')->middleware(['check_cart'])->group(function () {

    Route::get('payment/method', 'CheckoutController@choosePaymentMethod')
        ->name('choose_payment_method');

    Route::get('payment/online/success', 'CheckoutController@handleSuccessfullOnlinePayment')
        ->name('handle_succesfull_online_payment');

    Route::get('payment/offline/{paymentMethod}', 'CheckoutController@payUsingOfflineMethod')
        ->name('pay_with_offline_method');

    Route::post('payment/offline/{paymentMethod}', 'CheckoutController@processOfflinePayment')
        ->name('process_pay_with_offline_method');

    Route::get('payment/offline/status/success', 'CheckoutController@offlinePaymentSuccess')
        ->name('offline_payment_success');

    Route::get('payment/wallet', 'CheckoutController@processWalletPayment')
        ->name('pay_with_wallet');


    load_route('payment_gateways');
});


// My Account
Route::prefix('my-account')->group(function () {

    Route::get('/', 'MyAccountController@index')
        ->name('my_account');

    Route::patch('/edit-profile', 'MyAccountController@update_profile')
        ->name('update_my_profile');

    Route::patch('/change-password', 'MyAccountController@change_password')
        ->name('change_password');

    Route::post('/change-photo', 'MyAccountController@change_photo')
        ->name('change_photo');

    Route::get('orders', 'MyAccountController@orders')
        ->name('my_orders');
    
    Route::post('orders', 'MyAccountController@my_orders_datatable')
        ->name('my_orders_datatable');

    Route::post('wallet/topup', 'MyAccountController@walletTopup')
        ->name('my_wallet_topup');

    Route::post('wallet/transactions', 'WalletTransactionController@myWalletTransactionsDatatable')
        ->name('my_wallet_transactions');

    Route::post('payments', 'Payments\PaymentController@myPaymentsdatatable')
        ->name('my_payments');
});


Route::prefix('orders')->group(function () {

    Route::get('create', 'OrderController@create')
        ->name('order_page');

    Route::post('comment', 'OrderController@post_comment')
        ->name('post_comment');

    Route::post('{order}/deliverable/accept', 'OrderController@accept_delivered_item')
        ->name('accept_delivered_item')
        ->where('order', '[0-9]+');

    Route::get('{order}/revision/request', 'OrderController@revision_request_page')
        ->name('revision_request_page');

    Route::post('{order}/revision/request', 'OrderController@revision_request')
        ->name('post_revision_request')
        ->where('order', '[0-9]+');

    Route::get('{order}', 'OrderController@show')
        ->name('orders_show')
        ->where('order', '[0-9]+');

    Route::get('{order}/rating', 'RatingController@create')
        ->name('orders_rating')
        ->where('order', '[0-9]+');

    Route::post('{order}/rating', 'RatingController@store')
        ->name('ratings_store')
        ->where('order', '[0-9]+');

    Route::get('{order}/pay', 'CartController@makePaymentForExistingOrder')
        ->name('pay_for_existing_order');
});




Route::prefix('notifications')->group(function () {

    Route::get('unread', 'NotificationController@get_unread_notifications')
        ->name('get_unread_notifications');

    Route::get('count', 'NotificationController@push_notification')
        ->name('get_push_notification_count');

    Route::get('/notifications/redirect/{id}', 'NotificationController@redirect_url')
        ->name('notification_redirect_url');

    Route::get('/all', 'NotificationController@index')
        ->name('notifications_index');

    Route::post('/all', 'NotificationController@paginate')
        ->name('datatable_notifications');

    Route::get('/mark/read/all', 'NotificationController@mark_all_notification_as_read')
        ->name('notification_all_mark_as_read');
});
