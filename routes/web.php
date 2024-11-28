<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PoliController;

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

Route::get('/', [QueueController::class, 'selectLoket'])->name('home');
Route::post('/ambil-antrian/{loket}', [QueueController::class, 'ambilAntrian'])->name('queue.ambilAntrian');
Route::get('/ambil-antrian/{loketCode}', [QueueController::class, 'ambilAntrian'])->name('queue.ambilAntrian');
Route::get('/print-tiket/{queueId}', [QueueController::class, 'printTicket'])->name('queue.printTiket');


// Tampilan 2 - Dashboard Staf Loket
Route::get('/loket/{loket}', [QueueController::class, 'dashboardLoket'])->name('queue.dashboardLoket');
Route::post('/loket/{loket}/call', [QueueController::class, 'callQueue'])->name('queue.callQueue');
Route::post('/loket/{loket}/done/{number}', [QueueController::class, 'doneQueue'])->name('queue.doneQueue');

Route::get('/queue/{loket}/status', [QueueController::class, 'getQueueStatus']);

Route::get('/queue/history', [QueueController::class, 'history'])->name('queue.history');

// Login for admin only
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // Menampilkan form login
Route::post('/login', [LoginController::class, 'login']); // Memproses form login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// admin only
Route::middleware(['auth'])->group(function () {
    Route::get('polis', [PoliController::class, 'index'])->name('polis.index');
    Route::get('polis/create', [PoliController::class, 'create'])->name('polis.create');
    Route::post('polis', [PoliController::class, 'store'])->name('polis.store');
    Route::get('polis/{poli}/edit', [PoliController::class, 'edit'])->name('polis.edit');
    Route::put('polis/{poli}', [PoliController::class, 'update'])->name('polis.update');
    Route::delete('polis/{poli}', [PoliController::class, 'destroy'])->name('polis.destroy');

});
