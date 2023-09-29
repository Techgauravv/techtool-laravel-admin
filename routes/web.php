<?php

use App\Http\Controllers\{
    HomeController,
    UserController,
    ProjectController,
    ClientController,
    TaskController,
    LeaveController
};

use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes(['register' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    // Route::get('/', [UserController::class, 'index'])->name('index');
    // Route::get('/create', [UserController::class, 'create'])->name('create');
    // Route::post('/store', [UserController::class, 'store'])->name('store');
    // Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');

    // Route::patch('/update/{user}', [UserController::class, 'update'])->name('update');
    // Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::post('/store-update', [UserController::class, 'storeUpdate'])->name('store-update');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});

//  Projects
Route::middleware('auth')->prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/store', [ProjectController::class, 'store'])->name('store');
});

// Clients
Route::middleware('auth')->prefix('clients')->name('clients.')->group(function () {
    Route::post('/store-update', [ClientController::class, 'storeUpdate'])->name('store-update');
    Route::get('/update/status/{client_id}/{status}', [ClientController::class, 'updateStatus'])->name('status');
});

Route::middleware('auth')->group(function () {
    Route::resources([
        'clients' => ClientController::class,
        'users' => UserController::class,
    ]);
});
