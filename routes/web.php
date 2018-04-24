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

/**
 * 
 * Laravel is providing the auth middleware defined in Illuminate\Auth\Middleware\Authenticate
 * 
 * example: 
 *              Route::get('profile' , function(){
 *                  ...authenticated users may enter....
 *              })->middleware('auth');
 * 
 */

//Route::get('/', function () {
//    return view('member-log');
//})->middleware('auth');
Route::get('/', 'MemberLogController@index')->middleware('auth');
Auth::routes(); 
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');
Route::resource('resource-management', 'ResourceManagementController');

Route::resource('/member-log', 'MemberLogController');
Route::post('member-log/search', 'MemberLogController@search')->name('member-log.search');   
Route::post('member-log/log_detail_add', ['as'=>'ajaxImageUpload','uses'=>'MemberLogController@ajaxImageUpload']);   
Route::post('member-log/log_detail_delete', 'MemberLogController@log_detail_delete');   
   


