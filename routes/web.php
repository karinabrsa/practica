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



Route::get('ajaxpieza', 'AjaxpiezaController@index')->name('ajaxpieza');
Route::get('ajaxpieza/getdata', 'AjaxpiezaController@getdata')->name('ajaxpieza.getdata');
Route::POST('ajaxpieza/postdata', 'AjaxpiezaController@postdata')->name('ajaxpieza.postdata');
Route::get('ajaxpieza/fetchdata', 'AjaxpiezaController@fetchdata')->name('ajaxpieza.fetchdata');
Route::get('ajaxpieza/removedata', 'AjaxpiezaController@removedata')->name('ajaxpieza.removedata');