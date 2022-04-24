<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

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

Route::get('/lang',[
    'uses' => 'App\Http\Controllers\HomeController@lang',
    'as' => 'lang.index'
]);

Route::get('/', function () {
    try {
        DB::connection()->getPdo();
        if (!Schema::hasTable('application_settings'))
            return redirect('/install');
    } catch (\Exception $e) {
        return redirect('/install');
    }
    return redirect('dashboard');
});

Route::get('/clear', function() {
    $exitCode = Artisan::call('config:clear');
    echo $exitCode;
});


Auth::routes(['register' => false]);

Route::get('/install',[
    'uses' => 'App\Http\Controllers\InstallController@index',
    'as' => 'install.index'
]);

Route::post('/install',[
    'uses' => 'App\Http\Controllers\InstallController@install',
    'as' => 'install.install'
]);


Route::group(['middleware' => ['auth']], function() {
    Route::get('/facebook-apps/fbLogin/{id}',[
        'uses' => 'App\Http\Controllers\FacebookAppController@fbLogin',
        'as' => 'facebook-apps.fbLogin'
    ]);

    Route::get('/fb-login-callback', [App\Http\Controllers\CallbackController::class, 'loginCallback']);

    Route::get('/connect-account/index',[
        'uses' => 'App\Http\Controllers\ConnectAccountController@index',
        'as' => 'connect-account.index'
    ]);

    Route::resources([
        'facebook-apps' => App\Http\Controllers\FacebookAppController::class,
        'roles' => App\Http\Controllers\RoleController::class,
        'users' => App\Http\Controllers\UserController::class,
        'smtp' => App\Http\Controllers\SmtpConfigurationController::class,
    ]);

    Route::get('/profile/setting',[
        'uses' => 'App\Http\Controllers\ProfileController@setting',
        'as' => 'profile.setting'
    ]);

    Route::post('/profile/updateSetting',[
        'uses' => 'App\Http\Controllers\ProfileController@updateSetting',
        'as' => 'profile.updateSetting'
    ]);
    Route::get('/profile/password',[
        'uses' => 'App\Http\Controllers\ProfileController@password',
        'as' => 'profile.password'
    ]);

    Route::post('/profile/updatePassword',[
        'uses' => 'App\Http\Controllers\ProfileController@updatePassword',
        'as' => 'profile.updatePassword'
    ]);
    Route::get('/profile/view',[
        'uses' => 'App\Http\Controllers\ProfileController@view',
        'as' => 'profile.view'
    ]);

});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard',[
    'uses' => 'App\Http\Controllers\DashboardController@index',
    'as' => 'dashboard'
    ]);
});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/apsetting',[
    'uses' => 'App\Http\Controllers\ApplicationSettingController@index',
    'as' => 'apsetting'
    ]);

    Route::post('/apsetting/update',[
    'uses' => 'App\Http\Controllers\ApplicationSettingController@update',
    'as' => 'apsetting.update'
    ]);
});

Route::get('/home', function() {
    return redirect()->to('dashboard');
});
