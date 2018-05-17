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

Route::get('/updateusers_cron', 'SlackWorkSpaceController@updateUsers_cron')->name('workspaces.updateusers');
Route::post('/invite', 'SlackWorkSpaceController@invite')->name('workspaces.invite');

Route::post('/update-statuses', 'SlackChatController@updateUserStatuses_ajax')->name('workspaces.updateUserStatuses');
Route::post('/get-channel-chat', 'SlackChatController@getChannelChat_ajax')->name('workspaces.getChannelChat');
Route::post('/send-slack-message', 'SlackChatController@sendSlackMessage_ajax')->name('workspaces.sendSlackMessage');

Route::post('/update-status-slack', 'SlackController@updateUserStatuses_ajax')->name('slack.updateUserStatuses');


Route::post('/edit-detail', 'ResourceManagementController@editResourceDetail')->name('resource-management.editDetail');
Route::post('/add-detail', 'ResourceManagementController@addResourceDetail')->name('resource-management.addDetail');
Route::get('/delete-detail/{id}', 'ResourceManagementController@deleteResourceDetail')->name('resource-management.deleteDetail');

Route::get('allocateprodects', 'AllocateProjectsController@index')->name('allocate-projects.index');
Route::post('/allocateprojects/ajaxprofromuser', 'AllocateProjectsController@ajaxprofromuser');
Route::post('/allocateprojects/updateproj', 'AllocateProjectsController@updateproj');
Route::get('/allocation', 'AllocationController@index')->name('allocation.index');


Route::get('/get-resources-by-user/{id}', 'AllocationController@getResourcesByUser_ajax');
Route::get('/get-resources-by-project/{id}', 'AllocationController@getResourcesByProject_ajax');

Route::post('/update-user-resources', 'AllocationController@updateUserResources_ajax');
Route::post('/update-project-resources', 'AllocationController@updateProjectResources_ajax');


