<?php

use App\Http\Controllers\UserController;
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

Route::get('/dashboard',[UserController::class, 'loadDashboard'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::post('save-chat', [UserController::class, 'saveChat']);
Route::post('load-chats', [UserController::class, 'loadChats']);

Route::post('delete-chat', [UserController::class, 'deleteChat']);
Route::post('update-chat', [UserController::class, 'updateChat']);


//Groups routs
Route::get('/groups',[UserController::class, 'loadGroups'])->middleware(['auth'])->name('groups');
Route::post('/create-group',[UserController::class, 'createGroup'])->middleware(['auth'])->name('createGroup');
