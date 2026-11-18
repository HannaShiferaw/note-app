<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('notes.index');
});

// Notes are only for logged-in users. Guests are sent to the login page.
Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class);
});

require __DIR__.'/auth.php';
