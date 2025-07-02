<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\AdminController;

// -----------------------------
// Página principal
// -----------------------------
Route::get('/', [HomeController::class, 'index'])->name('inicio');

// -----------------------------
// Rutas de inscripción
// -----------------------------

// Selección de tipo de inscripción
Route::get('/registro', [InscripcionController::class, 'seleccionarTipo'])->name('registro.seleccionar');

// Mostrar formulario de inscripción según tipo (comprador/visitante)
Route::get('/registro/formulario', [InscripcionController::class, 'mostrarFormulario'])->name('registro.formulario');

// Procesar inscripción POST
Route::post('/registro/registrar', [InscripcionController::class, 'registrar'])->name('inscripcion.registrar');

// Mostrar formulario para validar documento
Route::get('/validar', [InscripcionController::class, 'mostrarValidar'])->name('registro.formValidar');

// Procesar validación de documento POST
Route::post('/validar', [InscripcionController::class, 'validar'])->name('inscripcion.validar');

// Ver comprobante PDF por ID
Route::get('/comprobante/{id}', [InscripcionController::class, 'verComprobanteEscaneado'])->name('comprobante.ver');

// Escanear entrada por código de barras
Route::get('/entrada/{code}', [InscripcionController::class, 'entrada'])->name('entrada.scan');

// Descargar comprobante como PDF (desde base64)
Route::post('/descargar-comprobante', function (Illuminate\Http\Request $request) {
    $pdfContent = base64_decode($request->input('pdf'));

    return Response::make($pdfContent, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="comprobante_inscripcion.pdf"',
    ]);
})->name('descargar.comprobante');

// -----------------------------
// Rutas de administración
// -----------------------------

// Login / Logout
Route::get('/admin/login', [AdminController::class, 'formLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Rutas protegidas por login
Route::middleware('auth')->group(function () {

    // Panel administrativo
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Guardar evento
    Route::post('/admin/evento', [AdminController::class, 'guardarEvento'])->name('admin.evento.guardar');

    // Editar evento
    Route::get('/admin/evento/editar/{id}', [AdminController::class, 'formEditarEvento'])->name('admin.evento.editar');

    // Generar PDF individual desde admin
    Route::get('/admin/inscrito/{id}/pdf', [AdminController::class, 'generarPDF'])->name('admin.inscrito.pdf');

    // Eliminar inscritos seleccionados
    Route::delete('/admin/inscritos/eliminar-seleccionados', [AdminController::class, 'eliminarSeleccionados'])->name('admin.inscritos.eliminar_seleccionados');
});
