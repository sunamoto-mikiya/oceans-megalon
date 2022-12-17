<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get(
        '/dashboard',
        function () {
            return view('dashboard');
        }
    );
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Task
    Route::prefix('projects/{projectId}')->name('task.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/tasks/{taskId}', [TaskController::class, 'show'])->name('show');
        Route::get('/tasks/{taskId}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::post('/tasks/{taskId}', [TaskController::class, 'update'])->name('update');
        Route::delete('/tasks/{taskId}', [TaskController::class, 'delete'])->name('delete');
    });

    //Board
    Route::prefix('projects/{projectId}/board/')->name('board.')->group(function () {
        Route::get('/', [BoardController::class, 'index'])->name('index');
        Route::post('/{taskId}', [BoardController::class, 'update'])->name('update');
    });
});

require __DIR__ . '/auth.php';

Auth::routes();
