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
Route::resource('workspaces', 'SlackWorkSpaceController');
Route::resource('applicants', 'ApplicantsController');
Route::resource('resource-management', 'ResourceManagementController');
Route::resource('forum-master', 'ForumMasterController');
Route::post('forum-master/add-forum-answer', 'ForumMasterController@addForumAnswer');
Route::resource('aws-master', 'AwsMasterController');
Route::resource('project' , 'ProjectController');
Route::resource('upwork' , 'UpworkController');

Route::resource('/member-log', 'MemberLogController');
Route::post('member-log/search', 'MemberLogController@search')->name('member-log.search');   
Route::post('member-log/log_detail_add', ['as'=>'ajaxImageUpload','uses'=>'MemberLogController@ajaxImageUpload']);   
Route::post('member-log/log_detail_delete', 'MemberLogController@log_detail_delete');

Route::post('slack/send', 'SlackController@sendMessage')->name('slack.send');
Route::get('slack', 'SlackController@index')->name('slack.index');

Route::get('messaging', 'SlackChatController@index')->name('messaging.index');

Route::get('/connection/{id}', 'SlackWorkSpaceController@connection')->name('workspaces.connection');
Route::post('/invite', 'SlackWorkSpaceController@invite')->name('workspaces.invite');



