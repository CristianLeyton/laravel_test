<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudiantePdfController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/estudiante/{id}/pdf', [EstudiantePdfController::class, 'generarPdf'])->name('estudiante.pdf');
