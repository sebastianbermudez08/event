<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\AdminController;

// ---------------------
// Página principal
// ---------------------
Route::get('/', [HomeController::class, 'index'])->name('inicio');

// ---------------------
// Rutas de inscripción
// ---------------------

// Seleccionar tipo de usuario
Route::get('/registro', [InscripcionController::class, 'seleccionarTipo'])->name('registro.seleccionar');

// Mostrar formulario de inscripción (dependiendo del tipo)
Route::get('/registro/formulario', [InscripcionController::class, 'mostrarFormulario'])->name('registro.formulario');

// Procesar inscripción
Route::post('/registro/registrar', [InscripcionController::class, 'registrar'])->name('inscripcion.registrar');

// Validar si el número de documento ya está inscrito
Route::get('/validar-documento', [InscripcionController::class, 'mostrarValidar'])->name('registro.validar');
Route::post('/validar-documento', [InscripcionController::class, 'validar'])->name('inscripcion.validar');

// Ver comprobante por ID
Route::get('/comprobante/{id}', [InscripcionController::class, 'verComprobante'])->name('comprobante.ver');

// Descargar comprobante PDF
Route::post('/descargar-comprobante', function (Illuminate\Http\Request $request) {
    $pdfContent = base64_decode($request->input('pdf'));

    return Response::make($pdfContent, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="comprobante_inscripcion.pdf"',
    ]);
})->name('descargar.comprobante');

// ---------------------
// Rutas admin
// ---------------------

// Login / Logout
Route::get('/admin/login', [AdminController::class, 'formLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin - acciones protegidas
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/admin/evento', [AdminController::class, 'guardarEvento'])->name('admin.evento.guardar');
    Route::get('/admin/evento/editar/{id}', [AdminController::class, 'formEditarEvento'])->name('admin.evento.editar');

    Route::get('/admin/inscrito/{id}/pdf', [AdminController::class, 'generarPDF'])->name('admin.inscrito.pdf');
    Route::delete('/admin/inscritos/eliminar-seleccionados', [AdminController::class, 'eliminarSeleccionados'])->name('admin.inscritos.eliminar_seleccionados');
});
