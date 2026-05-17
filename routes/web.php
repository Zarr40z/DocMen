<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentLogController;
use App\Http\Controllers\MemoController;
use App\Models\Memo;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('users', UserController::class);

});

Route::middleware(['auth'])->group(function () {

    Route::resource('documents', DocumentController::class);

    Route::post(
    '/documents/{id}/approve',
    [DocumentController::class, 'approve']
    )->name('documents.approve');

Route::post(
    '/documents/{id}/reject',
    [DocumentController::class, 'reject']
    )->name('documents.reject');

Route::post(
    '/documents/{id}/disposisi',
    [DocumentController::class, 'disposisi']
    )->name('documents.disposisi');

Route::post(
    '/documents/{id}/final-approve',
    [DocumentController::class, 'finalApprove']
    )->name('documents.finalApprove');

});

Route::middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    });

});

Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    });

});

Route::middleware(['auth', 'role:direktur'])->group(function () {

    Route::get('/direktur/dashboard', function () {
        return view('direktur.dashboard');
    });

});
Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::get('/document-logs',
    [DocumentLogController::class, 'index']
)->name('document.logs');

Route::resource('memos', MemoController::class);

Route::resource('memos', MemoController::class);
    
require __DIR__.'/auth.php';
