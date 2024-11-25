<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FolderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/upload', [FileUploadController::class, 'showForm'])->name('upload.form');
Route::post('/upload', [FileUploadController::class, 'uploadFiles'])->name('file.upload');
Route::get('/search', [FileUploadController::class, 'search'])->name('uploads.search');

Route::get('/folder-form', [FolderController::class, 'folderForm'])->name('folders.form');
Route::post('/store-folder/{parentId?}', [FolderController::class, 'storeFolder'])->name('folders.store');
Route::get('/folders', [FolderController::class, 'showFolders'])->name('folders.index');
Route::get('folder-details/{path}/{name}', [FolderController::class, 'show'])->name('folders.show');
Route::post('folder-data-details', [FolderController::class, 'showData'])->name('folders.showData');
Route::get('/file-move/{id}', [FolderController::class, 'move'])->name('move');
Route::post('/file-move', [FolderController::class, 'moveFile'])->name('moveFile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
