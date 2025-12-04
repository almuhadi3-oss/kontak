<?php

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
    return view('welcome');
});
use App\Http\Controllers\PesanController;

Route::post('/api/pesan', [PesanController::class, 'store']);

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\BeritaController;

// Menampilkan daftar pengaduan
Route::get('/admin/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');

// Mengupdate status pengaduan
Route::post('/admin/pengaduan/{id}/update-status', [PengaduanController::class, 'updateStatus']);

// Menghapus pengaduan (tolak)
Route::delete('/admin/pengaduan/{id}', [PengaduanController::class, 'destroy']);

// Menghapus pengaduan secara permanen (general delete)
Route::delete('/admin/pengaduan/{id}/delete-general', [PengaduanController::class, 'deleteGeneral']);

// Cek status laporan masyarakat (API frontend)
Route::get('/api/cek-laporan/{kode}', [PengaduanController::class, 'cekStatus']);

// Route untuk menerima pengaduan masyarakat (dari form layanan)
Route::post('/api/pengaduan', [PengaduanController::class, 'store']);

// Routes untuk berita management
Route::resource('admin/berita', BeritaController::class)->names([
    'index' => 'berita.index',
    'create' => 'berita.create',
    'store' => 'berita.store',
    'show' => 'berita.show',
    'edit' => 'berita.edit',
    'update' => 'berita.update',
    'destroy' => 'berita.destroy',
]);

// API untuk mendapatkan berita terbaru (untuk frontend)
Route::get('/api/berita', [BeritaController::class, 'getLatest']);
Route::get('/api/berita/{id}', [BeritaController::class, 'getById']);
