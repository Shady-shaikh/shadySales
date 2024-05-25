<?php

use App\Http\Controllers\backend\AccountController;
use App\Http\Controllers\backend\BackendmenuController;
use App\Http\Controllers\backend\BackendsubmenuController;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\AdminusersController;
use App\Http\Controllers\backend\CompanyController;
use App\Http\Controllers\backend\PartyController;
use App\Http\Controllers\backend\MasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('/login', [AccountController::class, 'login'])->name('admin.login');
    Route::post('/auth_user', [AccountController::class, 'auth_user'])->name('admin.auth_user');
    Route::any('/forgot_password', [AccountController::class, 'forgot_password'])->name('admin.forgot_password');
    Route::post('/recover_password', [AccountController::class, 'recover_password'])->name('admin.recover_password');

    Route::group(['middleware' => 'admin.auth'], function () {

        // master routes
        Route::post('/store_category', [MasterController::class, 'store_category'])->name('admin.store_category');
        Route::post('/store_group', [MasterController::class, 'store_group'])->name('admin.store_group');
        Route::get('/get_group', [MasterController::class, 'get_group'])->name('admin.get_group');
        Route::get('/get_category', [MasterController::class, 'get_category'])->name('admin.get_category');
        

        Route::any('/logout', [AccountController::class, 'logout'])->name('admin.logout');
        Route::get('/', [AccountController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('permission', PermissionController::class);
        Route::resource('backendmenu', BackendmenuController::class);
        Route::resource('backendsubmenu', BackendsubmenuController::class);
        Route::resource('role', RoleController::class);
        Route::resource('users', AdminusersController::class);
        Route::resource('party', PartyController::class);
        Route::resource('company', CompanyController::class);
        Route::post('company/country_state_city', [CompanyController::class, 'country_state_city'])->name('admin.country_state_city');
    });
});
