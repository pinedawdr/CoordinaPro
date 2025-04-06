<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Agregar esta ruta para manejar las referencias a 'home'
Route::redirect('/home', '/dashboard')->name('home');

// Añadir ruta de logout
Route::post('/logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ActivityController::class, 'dashboard'])->name('dashboard');
    
    // Activities
    Route::resource('activities', ActivityController::class)->except(['show', 'edit']);
    Route::get('/calendar', [ActivityController::class, 'calendar'])->name('activities.calendar');
    Route::get('/calendar-data', [ActivityController::class, 'calendarData'])->name('activities.calendar-data');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    
    // Exports
    Route::get('/export-excel', [ActivityController::class, 'exportExcel'])->name('activities.exportExcel');
    Route::get('/export-pdf', [ActivityController::class, 'exportPdf'])->name('activities.exportPdf');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de reportes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/data', [ReportController::class, 'getReportData'])->name('reports.data');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
});

// Añadir ruta de diagnóstico para el calendario
Route::get('/api/calendar-events', function() {
    $activities = App\Models\Activity::all()->map(function ($activity) {
        return [
            'id' => $activity->id,
            'title' => $activity->descripcion,
            'start' => $activity->fecha_actividad->format('Y-m-d'),
            'created_at' => $activity->created_at->format('Y-m-d H:i:s')
        ];
    })->toArray();
    
    return response()->json([
        'count' => count($activities),
        'events' => $activities
    ]);
})->middleware('auth')->name('api.calendar-events');

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';
