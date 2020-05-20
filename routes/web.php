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

Auth::routes(['register'=>false]);
// Auth::routes();

Route::group(['middleware' => 'auth'], function() {

	Route::get('/', 'HomeController@index')->name('home');

	Route::get('/posts', 'PostsController@index')->name('posts');


	Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){
		Route::resource('users', 'UserController');
		Route::resource('roles', 'RolesController');
		Route::resource('permissions', 'PermissionsController');


		// Route::get('export', 'MyController@export')->name('export');
		Route::get('/import', 'ImportController@index')->name('import');
		Route::post('import', 'ImportController@import')->name('import');
	});
});

