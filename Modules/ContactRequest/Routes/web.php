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

use Illuminate\Support\Facades\Route;

Route::middleware(['admin','permission'])->prefix('contactrequest')->as('contactrequest.')->group(function() {
    Route::get('/contact', 'ContactController@index')->name('contact.index');
    Route::get('/contact-get-data', 'ContactController@getData')->name('contact.get-data');
    Route::get('/contact/{id}', 'ContactController@show')->name('contact.show');
    Route::post('/contact/delete', 'ContactController@destroy')->name('contact.delete')->middleware('prohibited_demo_mode');



	    Route::get('/fragment', 'ContactController@index')->name('fragment.index');
    Route::get('/fragment-get-data', 'ContactController@getData')->name('fragment.get-data');
    Route::get('/fragment/{id}', 'ContactController@show')->name('fragment.show');
    Route::post('/fragment/delete', 'ContactController@destroy')->name('fragment.delete')->middleware('prohibited_demo_mode');
});
