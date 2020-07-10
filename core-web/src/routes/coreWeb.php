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


/*### Start LOGIN PAGE ###*/
//Route::get('/', 'HomeController@index')->name('home');
Route::view('/login', 'public.login')->name('public.login');
Route::post('/login', 'UserMgmt\LoginController@postLogin')->name('login');
/*### End LOGIN PAGE ###*/

//Auth::routes();

/*### Start LANDING PAGE ###*/
Route::get('/home', 'HomeController@index')->name('secured.home')->middleware('auth');
/*### END LANDING PAGE ###*/

/*### Start LOGOUT PAGE ###*/
Route::get('/logout', 'UserMgmt\LoginController@logout')->name('get.logout');
Route::post('/logout', 'UserMgmt\LoginController@logout')->middleware('auth')->name('logout');
/*### End LOGOUT PAGE ###*/

/*### Common Route ###*/
Route::prefix('common')->group(function () {
    Route::post('infoStaff', 'UserMgmt\UserMgmtController@infoStaff')->name('common.infoStaff')->middleware('auth');
});

/*### Start Module Role ###*/
Route::group(['prefix' => 'role',  'middleware' => 'auth'], function () {
    Route::get('/', 'UserMgmt\RoleMgmtController@index');
    Route::post('grid', 'UserMgmt\RoleMgmtController@gridList')->name('role.grid');
    Route::get('new', 'UserMgmt\RoleMgmtController@new')->name('role.new');
    Route::post('create', 'UserMgmt\RoleMgmtController@create')->name('role.create');
    Route::get('read/{id}', 'UserMgmt\RoleMgmtController@read')->where(['id' => '[0-9]+'])->name('role.read');
    Route::post('update', 'UserMgmt\RoleMgmtController@update')->name('role.update');
});
Route::group(['prefix' => 'roleFunction',  'middleware' => 'auth'], function () {
    Route::get('grid/{roleId}', 'UserMgmt\RoleMgmtController@gridListFunction')->name('roleFunction.grid');
    Route::get('new', 'UserMgmt\RoleMgmtController@new')->name('roleFunction.new');
    Route::post('create', 'UserMgmt\RoleMgmtController@createRoleFunction')->name('roleFunction.create');
    Route::get('read/{id}', 'UserMgmt\RoleMgmtController@read')->where(['id' => '[0-9]+'])->name('roleFunction.read');
    Route::post('update', 'UserMgmt\RoleMgmtController@updateRoleFunction')->name('roleFunction.update');
    Route::get('delete/{roleId}/{functionCode}', 'UserMgmt\RoleMgmtController@deleteRoleFunction')->name('roleFunction.delete');
});
/*### End Module Role ###*/

/*### Start Module Role ###*/
Route::group(['prefix' => 'menuMgmt',  'middleware' => 'auth'], function () {
    Route::get('/', 'MenuMgmt\MenuMgmtController@index');
    Route::post('grid', 'MenuMgmt\MenuMgmtController@gridList')->name('menuMgmt.grid');
    Route::get('new', 'MenuMgmt\MenuMgmtController@new')->name('menuMgmt.new');
    Route::post('create', 'MenuMgmt\MenuMgmtController@create')->name('menuMgmt.create');
    Route::get('read/{id}', 'MenuMgmt\MenuMgmtController@read')->where(['id' => '[0-9]+'])->name('menuMgmt.read');
    Route::post('update', 'MenuMgmt\MenuMgmtController@update')->name('menuMgmt.update');
    Route::get('delete/{id}', 'MenuMgmt\MenuMgmtController@delete')->where(['id' => '[0-9]+'])->name('menuMgmt.delete');
});
/*### End Module Role ###*/

/* ### Start Module User Info ### */
Route::group(['prefix' => 'userInfo', 'middleware' => 'auth'], function () {
    Route::get('/', 'UserMgmt\UserMgmtController@index');
    Route::post('grid', 'UserMgmt\UserMgmtController@gridList')->name('userInfo.grid');
    Route::get('new', 'UserMgmt\UserMgmtController@new')->name('userInfo.new');
    Route::post('create', 'UserMgmt\UserMgmtController@create')->name('userInfo.create');
    Route::get('read/{id}', 'UserMgmt\UserMgmtController@read')->name('userInfo.read');
    Route::post('update', 'UserMgmt\UserMgmtController@update')->name('userInfo.update');
});
/* ### End Module User Info ### */
