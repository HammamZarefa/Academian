<?php
//if(!env('DISABLE_WEBSITE'))
//{
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('homepage');
//}
//else
//{
//    Route::get('/', 'Auth\LoginController@showLoginForm')->name('homepage');
//}

Route::get('pricing', 'HomeController@pricing')->name('pricing');
Route::get('contact', 'HomeController@contact')->name('contact');
Route::post('contact', 'HomeController@handle_email_query')->name('handle_email_query');
Route::get('instant-quote', 'OrderController@quote')->name('instant_quote');
Route::get('faq', 'HomeController@content')->name('faq');
Route::get('how-it-works', 'HomeController@content')->name('how_it_works');
Route::get('privacy-policy', 'HomeController@content')->name('privacy_policy');
Route::get('revision-policy', 'HomeController@content')->name('revision_policy');
Route::get('disclaimer', 'HomeController@content')->name('disclaimer');
Route::get('terms-and-conditions', 'HomeController@content')->name('terms_and_conditions');
Route::get('money-back-guarantee', 'HomeController@content')->name('money_back_guarantee');
Route::get('sitemap.xml', 'SitemapController@index')->name('sitemap.xml');
Route::get('page-sitemap.xml', 'SitemapController@page')->name('page-sitemap.xml');
Route::get('blog', 'HomeController@blog')->name('blog');
Route::get('blog/search', 'HomeController@search')->name('search');
Route::get('blog/{slug}', 'HomeController@blogshow')->name('blogshow');
Route::get('categories/{category:slug}', 'HomeController@category')->name('category');
Route::get('tags/{tag:slug}', 'HomeController@tag')->name('tag');
//Route::group(['middleware' => []], function () {

    Route::get('plagiarism1/', 'PlagiarismController@index')->name('plagiarism');
    Route::post('plagiarism1/detect', 'PlagiarismController@detect')->name('detect');
    Route::get('paraphrase/', 'parphrazersController@index')->name('paraphrase');
    Route::post('paraphrase/result', 'parphrazersController@detect')->name('paraphrase.result');
    Route::get('summarize/', 'SummarizesController@index')->name('summarize');
    Route::post('summarize/result', 'SummarizesController@detect')->name('summarize.result');
//});

//P@ssw0rd


