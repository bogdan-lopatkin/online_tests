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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/test','CategoriesController@index');


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories','CategoryController', [
    'categories' => 'category',
    'only' => ['index','show']

]);

// Tests routes
Route::get('/tests','Test\TestController1@index')->name('tests');
Route::get('/tests/{category}/','Test\TestController1@showCategory')->name('tests.category');
Route::get('/tests/search','Test\TestController1@showSearched')->name('tests.search');
Route::get('/test/{test_id}','Test\TestController1@startTest')->name('test')->middleware('verified');
Route::post('result','Test\ResultController')->name('showResult')->middleware('verified');



// Admin routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin','as' => 'admin.'], function() {
    Route::resource('/','DashboardController')->names('dashboard');
    Route::resource('categories','CategoryController')->names('category');
    Route::resource('users','UserController')->names('user');
    Route::resource('roles','RoleController')->names('role');
    Route::resource('tests','TestController')->names('test')->except('index');
    Route::get('/tests/{sortby?}', 'TestController@index')->name('test.index');
    Route::resource('questions','QuestionController')->names('question');
    Route::resource('answers','AnswerController')->names('answer');
});//->middleware('isAdmin');

// invokable routes

// API ROUTES
Route::post('/api/test/save','API\SaveTestController');
Route::post('/api/file/upload','API\FileController@store')->name('img.upload');
Route::post('/api/file/delete','API\FileController@destroy')->name('img.destroy');

