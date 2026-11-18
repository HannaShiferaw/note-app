<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('notes.index');
});

// Notes are only for logged-in users. Guests are sent to the login page.
Route::middleware('auth')->group(function () {
    // The dashboard is the notes list.
    Route::get('/dashboard', function () {
        return redirect()->route('notes.index');
    })->name('dashboard');

    Route::resource('notes', NoteController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
