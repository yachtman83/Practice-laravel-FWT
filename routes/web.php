<?php

use App\Livewire\Tasks\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/tasks', Index::class)->name('tasks.index');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
