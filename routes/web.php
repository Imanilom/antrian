<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
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

// Tampilan 1 - Pilihan Loket
Route::get('/', [QueueController::class, 'selectLoket'])->name('queue.selectLoket');
Route::post('/ambil-antrian/{loket}', [QueueController::class, 'ambilAntrian'])->name('queue.ambilAntrian');

// Tampilan 2 - Dashboard Staf Loket
Route::get('/loket/{loket}', [QueueController::class, 'dashboardLoket'])->name('queue.dashboardLoket');
Route::post('/loket/{loket}/call', [QueueController::class, 'callQueue'])->name('queue.callQueue');
Route::post('/loket/{loket}/done/{number}', [QueueController::class, 'doneQueue'])->name('queue.doneQueue');

Route::get('/queue/{loket}/status', [QueueController::class, 'getQueueStatus']);
