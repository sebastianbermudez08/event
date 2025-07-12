<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
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
Route::get('/registro', [InscripcionController::class, 'seleccionarTipo'])->name('registro.seleccionar');
Route::get('/registro/formulario', [InscripcionController::class, 'mostrarFormulario'])->name('registro.formulario');
Route::post('/registro/registrar', [InscripcionController::class, 'registrar'])->name('inscripcion.registrar');

Route::get('/validar', [InscripcionController::class, 'mostrarValidar'])->name('registro.formValidar');
Route::post('/validar', [InscripcionController::class, 'validar'])->name('inscripcion.validar');

//Route::get('/comprobante/{id}', [InscripcionController::class, 'verComprobanteEscaneado'])->name('comprobante.ver');
Route::get('/comprobante/{tipo}/{id}', [InscripcionController::class, 'verComprobanteEscaneado'])->name('comprobante.ver');
Route::get('/entrada/{code}', [InscripcionController::class, 'entrada'])->name('entrada.scan');

Route::post('/descargar-comprobante', function (Request $request) {
    $pdfContent = base64_decode($request->input('pdf'));
    return Response::make($pdfContent, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="comprobante_inscripcion.pdf"',
    ]);
})->name('descargar.comprobante');

// -----------------------------
// Rutas de administración
// -----------------------------
Route::get('/admin/login', [AdminController::class, 'formLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// -----------------------------
// Rutas protegidas por autenticación
// -----------------------------
Route::middleware('auth')->group(function () {

    // Procesar ingreso desde el formulario
    Route::post('/ingreso/procesar', [InscripcionController::class, 'procesarIngreso'])->name('ingreso.process');
    Route::post('/ingreso', [InscripcionController::class, 'procesarIngreso'])->name('ingreso.process');

    // Vista de ingreso para usuarios con rol 'ingresos'
    Route::get('/ingreso', function () {
        return view('ingreso.index');
    })->name('ingreso.index');

    // Panel de administración
    
    Route::get('/login', [AdminController::class, 'formLogin'])->name('login');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/admin/evento', [AdminController::class, 'guardarEvento'])->name('admin.evento.guardar');
    Route::get('/admin/evento/editar/{id}', [AdminController::class, 'formEditarEvento'])->name('admin.evento.editar');

    Route::get('/admin/inscrito/{id}/pdf', [AdminController::class, 'generarPDF'])->name('admin.inscrito.pdf');
    Route::delete('/admin/inscritos/eliminar-seleccionados', [AdminController::class, 'eliminarSeleccionados'])->name('admin.inscritos.eliminar_seleccionados');
});
