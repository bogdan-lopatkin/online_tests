<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['web','checkIfBanned']], function () {
    Auth::routes(['verify' => true]);
    Route::auth();
Route::get('/', function () {
    return view('welcome');
});


   // SPA controller
    Route::get('/tests{any?}', 'SpaController@index')->where('any', '.*')->name('spa');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/settings', 'HomeController@settings')->name('home.settings');
    Route::resource('/user', 'UserController')->names('user')->only(['show','update']);



// Tests routes
Route::group(['namespace' => 'Test', 'prefix' => 'api'], function() {
    Route::get('/', 'TestController1@index')->name('tests');
    Route::get('/{category}/', 'TestController1@showCategory')->name('tests.category');
    Route::get('/search', 'TestController1@showSearched')->name('tests.search');
});
Route::get('/test/{test_id}', 'Test\TestController1@startTest')->name('test')->middleware(['auth']);
Route::post('result','Test\ResultController')->name('showResult')->middleware(['auth']);



// Admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin','as' => 'admin.', 'middleware' => 'checkIfAdmin'], function() {  //,'middleware' => 'checkIfAdmin'
    Route::resource('/','DashboardController')->names('dashboard');
    Route::resource('categories','CategoryController')->names('category');
    Route::resource('users','UserController')->names('user');
    Route::resource('roles','RoleController')->names('role');
    Route::resource('tests','TestController')->names('test')->except('index');
    Route::get('/tests/{sortby?}', 'TestController@index')->name('test.index');
    Route::resource('questions','QuestionController')->names('question');
    Route::get('/answer_add/{question_id?}',  'AnswerController@create')->name('answer.create');
    Route::resource('answers','AnswerController')->names('answer')->except('create');
});

// Teacher routes
Route::group(['namespace' => 'Group', 'prefix' => 'group','as' => 'group.'], function() {
    Route::get('/', 'GroupController@index')->name('index');
    Route::post('/update', 'GroupController@update')->name('update');
    Route::resource('/students', 'StudentController')->names('students');
    Route::resource('/homework', 'HomeworkController')->names('homework');
    Route::get('/articles', 'GroupController@articles')->name('articles');
    Route::resource('/tests', 'TestController')->names('tests');
});

// Forum routes

Route::group(['namespace' => 'Forum', 'prefix' => 'forum','as' => 'forum.'], function() {
    Route::resource('/threads', 'ThreadController')->names('thread');
    Route::resource('/threads/answer', 'AnswerController')->names('thread.answer')->only('store','update','destroy');
    Route::post('/threads/answer/like', 'LikesController')->name('like');

});







Route::post('/api/test/save','API\SaveTestController');
Route::post('/api/file/upload','API\FileController@store')->name('img.upload');
Route::post('/api/file/delete','API\FileController@destroy')->name('img.destroy');
Route::post('/api/file/avatar','API\FileController@storeAvatar')->name('avatar.upload');


});
