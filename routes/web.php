<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
    Route::get('/supplier/delete/{supplier}', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.delete');

    // Layup routes (scoped to supplier)
    Route::get('/supplier/{supplier}/export', [\App\Http\Controllers\ImportExportController::class, 'export'])->name('supplier.export');
    Route::post('/supplier/{supplier}/import', [\App\Http\Controllers\ImportExportController::class, 'import'])->name('supplier.import');
    Route::get('/supplier/{supplier}/layup', [\App\Http\Controllers\LayupController::class, 'index'])->name('layup.index');
    Route::get('/supplier/{supplier}/layup/create', [\App\Http\Controllers\LayupController::class, 'create'])->name('layup.create');
    Route::post('/supplier/{supplier}/layup', [\App\Http\Controllers\LayupController::class, 'store'])->name('layup.store');
    Route::get('/layup/{layup}/edit', [\App\Http\Controllers\LayupController::class, 'edit'])->name('layup.edit');
    Route::put('/layup/{layup}', [\App\Http\Controllers\LayupController::class, 'update'])->name('layup.update');
    Route::delete('/layup/{layup}', [\App\Http\Controllers\LayupController::class, 'destroy'])->name('layup.destroy');
    Route::get('/layup/{layup}/delete', [\App\Http\Controllers\LayupController::class, 'destroy'])->name('layup.delete');

    // Layer routes (nested under Layup)
    Route::get('/layup/{layup}/layer', [\App\Http\Controllers\LayerController::class, 'index'])->name('layer.index');
    Route::get('/layup/{layup}/layer/create', [\App\Http\Controllers\LayerController::class, 'create'])->name('layer.create');
    Route::post('/layup/{layup}/layer', [\App\Http\Controllers\LayerController::class, 'store'])->name('layer.store');
    Route::get('/layer/{layer}/edit', [\App\Http\Controllers\LayerController::class, 'edit'])->name('layer.edit');
    Route::put('/layer/{layer}', [\App\Http\Controllers\LayerController::class, 'update'])->name('layer.update');
    Route::delete('/layer/{layer}', [\App\Http\Controllers\LayerController::class, 'destroy'])->name('layer.destroy');
    Route::get('/layer/{layer}/delete', [\App\Http\Controllers\LayerController::class, 'destroy'])->name('layer.delete');
});

require __DIR__ . '/auth.php';
