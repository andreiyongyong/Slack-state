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
Route::resource('keywords', 'ForbiddenKeywordsController');
Route::resource('resource-management', 'ResourceManagementController');
Route::resource('forum-master', 'ForumMasterController');
Route::post('forum-master/add-forum-answer', 'ForumMasterController@addForumAnswer');
Route::resource('aws-master', 'AwsMasterController');
Route::resource('project' , 'ProjectController');
Route::resource('upwork' , 'UpworkController');
Route::resource('slack-chat-pair' , 'SlackChatPairController');

Route::resource('slack-admin-state' , 'SlackAdminStateController');
Route::post('slack-admin-state/active', 'SlackAdminStateController@activeState');

Route::resource('/member-log', 'MemberLogController');
Route::resource('/git-manage', 'GitManageController');
Route::post('member-log/search', 'MemberLogController@search')->name('member-log.search');   
Route::post('member-log/log_detail_add', ['as'=>'ajaxImageUpload','uses'=>'MemberLogController@ajaxImageUpload']);   
Route::post('member-log/log_detail_delete', 'MemberLogController@log_detail_delete');


Route::post('slack/send', 'SlackController@sendMessage')->name('slack.send');
Route::get('slack', 'SlackController@index')->name('slack.index');


Route::get('slack-chat/{id}', 'SlackChatPairController@slackChat')->name('slack-chat.slackChat');

Route::get('messaging', 'SlackChatController@index')->name('messaging.index');

Route::get('/updateusers_cron', 'SlackWorkSpaceController@updateUsers_cron')->name('workspaces.updateusers');
Route::post('/invite', 'SlackWorkSpaceController@invite')->name('workspaces.invite');

Route::post('/update-statuses', 'SlackChatController@updateUserStatuses_ajax')->name('workspaces.updateUserStatuses');
Route::post('/get-channel-chat', 'SlackChatController@getChannelChat_ajax')->name('workspaces.getChannelChat');
Route::post('/send-slack-message', 'SlackChatController@sendSlackMessage_ajax')->name('workspaces.sendSlackMessage');

//slack chat pair
Route::post('/update-statuses-pair', 'SlackChatPairController@updateUserStatuses_ajax');
Route::post('/get-channel-chat-pair', 'SlackChatPairController@getChannelChat_ajax');
Route::post('/send-slack-message-pair', 'SlackChatPairController@sendSlackMessage_ajax');
Route::post('/select-pair', 'SlackChatPairController@selectPair_ajax');
Route::post('/upload-file', 'SlackChatPairController@uploadFile_ajax');

Route::post('/update-status-slack', 'SlackController@updateUserStatuses_ajax')->name('slack.updateUserStatuses');


Route::post('/edit-detail', 'ResourceManagementController@editResourceDetail')->name('resource-management.editDetail');
Route::post('/add-detail', 'ResourceManagementController@addResourceDetail')->name('resource-management.addDetail');
Route::get('/delete-detail/{id}', 'ResourceManagementController@deleteResourceDetail')->name('resource-management.deleteDetail');

Route::get('allocateprojects', 'AllocateProjectsController@index')->name('allocate-projects.index');
Route::post('/allocateprojects/ajaxprofromuser', 'AllocateProjectsController@ajaxprofromuser');
Route::post('/allocateprojects/updateproj', 'AllocateProjectsController@updateproj');
Route::post('/allocateprojects/del_proj', 'AllocateProjectsController@delproj');

Route::get('/allocation', 'AllocationController@index')->name('allocation.index');

Route::get('taskallocation', 'TaskAllocationController@index')->name('task-allocation.index');
Route::post('/taskallocation/taskfromuser', 'TaskAllocationController@taskfromuser');
Route::post('/taskallocation/updatetask', 'TaskAllocationController@updatetask');
Route::post('/taskallocation/del_task', 'TaskAllocationController@deltask');
Route::post('/taskallocation/taskfromproj', 'TaskAllocationController@taskfromproj');

Route::post('/gitmanage/ajaxrepofromuser', 'GitManageController@ajaxrepofromuser');
Route::post('/gitmanage/updaterepos', 'GitManageController@updaterepos');
Route::post('/gitmanage/del_invite', 'GitManageController@delinvite');

Route::get('/get-resources-by-user/{id}', 'AllocationController@getResourcesByUser_ajax');
Route::get('/get-resources-by-project/{id}', 'AllocationController@getResourcesByProject_ajax');

Route::post('/update-user-resources', 'AllocationController@updateUserResources_ajax');
Route::post('/delete-user-resource', 'AllocationController@deleteUserResource_ajax');

// tokens
Route::post('/add-token', 'SlackWorkspaceController@addToken')->name('workspace-tokens.addToken');
Route::get('/delete-token/{id}', 'SlackWorkspaceController@deleteToken')->name('workspace-tokens.deleteToken');

