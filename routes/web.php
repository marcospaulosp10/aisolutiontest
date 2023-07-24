<?php

use App\Console\Commands\ProcessDocumentQueue;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
Route::post('/documents/import', [DocumentController::class, 'import'])->name('documents.import');

Route::get('/process-queue', function () {
    // Executa o comando "queue:work" em segundo plano
    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
    ]);

    return redirect()->route('documents.index')->with('success', 'Fila executada com sucesso!');
})->name('documents.queue_execute');
