<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;

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


Route::group(['prefix' => '/', 'namespace' => 'Home'], function () {

    Route::get('/', 'HomeController@Index')
        ->name('home-page');


});

Route::group(['prefix' => '/file'], function () {
    Route::get('/{hashFile}', 'Files@GetFileByHash')
        ->name('get-file-by-hash');
});

Route::group(['prefix' => '/catalog', 'namespace' => 'Catalog'], function () {

    Route::group(['prefix' => '/video'], function () {

        Route::get('/all', 'VideoController@Index')
            ->name('all-video-page');

        Route::get('/create', 'VideoController@CreateOrEdit')
            ->name('video-create-page');

        Route::get('/edit/{videoId}', 'VideoController@CreateOrEdit')
            ->name('video-edit-page');

        Route::post('/save', 'VideoController@ChangeSave')
            ->name('video-save');

        Route::post('/delete/{videoId}', 'VideoController@Delete')
            ->name('video-delete');

        Route::get('/{semanticUrlVideo}','VideoController@VideoPage')
            ->name('video-page');

    });

});

Route::group(['prefix' => '/management', 'namespace' => 'Management'], function () {

    Route::get('/', 'ManagementController@Index')
        ->name('management-home-page');

    Route::group(['prefix' => '/auth'], function () {
        Route::get('/login', 'ManagementController@LoginPage')
            ->name('management-login-page');

        Route::post('/login', 'ManagementController@Login')
            ->name('management-login');

        Route::get('/logout', 'ManagementController@Logout')
            ->name('management-logout');
    });

});
