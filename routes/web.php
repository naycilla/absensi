<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Siswa;
use App\Http\Middleware\Operator;
use App\Http\Middleware\Sekretaris;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LoginSiswaController;
use App\Http\Controllers\SekretarisController;
use App\Http\Controllers\AbsensiDetailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelolaUserController;
use App\Http\Controllers\LoginOperatorController;
use App\Http\Controllers\LoginSekretarisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sekretaris', [LoginSekretarisController::class, 'login']);
Route::post('/sekretaris', [LoginSekretarisController::class, 'authenticate']);
Route::get('/sekretaris/logout', [LoginSekretarisController::class, 'logout']);

Route::get('/', [LoginSiswaController::class, 'login']);
Route::post('/siswa', [LoginSiswaController::class, 'authenticate']);
Route::get('/siswa/logout', [LoginSiswaController::class, 'logout']);

Route::get('/operator', [LoginOperatorController::class, 'login']);
Route::post('/operator', [LoginOperatorController::class, 'authenticate']);
Route::get('/operator/logout', [LoginOperatorController::class, 'logout']);

Route::get('/admin', [LoginAdminController::class, 'login']);
Route::post('/admin', [LoginAdminController::class, 'authenticate']);
Route::get('/admin/logout', [LoginAdminController::class, 'logout']);

Route::middleware([Sekretaris::class])->group(function() {
    
    Route::get('/sekretaris/dashboard', [SekretarisController::class, 'dashboard']);
    Route::get('/sekretaris/siswa-hadir', [SekretarisController::class, 'hadir']);
    Route::get('/sekretaris/siswa-sakit', [SekretarisController::class, 'sakit']);
    Route::get('/sekretaris/siswa-izin', [SekretarisController::class, 'izin']);
    Route::get('/sekretaris/siswa-alpa', [SekretarisController::class, 'alpa']);

    Route::get('/sekretaris/absensi', [AbsensiController::class, 'index']);
    Route::get('/sekretaris/detail-absensi/{id}', [AbsensiController::class, 'detail']);
    Route::get('/sekretaris/absensi/tambah', [AbsensiController::class, 'create']);
    Route::get('/sekretaris/absensi-detail/{id}', [AbsensiDetailController::class, 'index']);
    Route::get('/sekretaris/absensi-detail/{nisn}/hapus', [AbsensiDetailController::class, 'destroy']);
    Route::post('/sekretaris/tambah-absensi', [AbsensiDetailController::class, 'create']);
    Route::get('/sekretaris/absensi/{id}', [AbsensiDetailController::class, 'store']);
    Route::get('/sekretaris/download/{bukti}/{file}', [SekretarisController::class, 'download']);
    Route::get('/sekretaris/download/', [SekretarisController::class, 'back']);

    Route::resource('/sekretaris/data-siswa', DataSiswaController::class, ['names' => 'sekretaris_siswa']);
    Route::get('/sekretaris/data-siswa/{absen}', [DataSiswaController::class, 'show']);
    Route::get('/sekretaris/data-siswa/{absen}/hapus', [DataSiswaController::class, 'delete']);
    Route::get('/sekretaris/data-siswa/{absen}/edit', [DataSiswaController::class, 'edit']);
    Route::post('/sekretaris/data-siswa/{absen}/edit', [DataSiswaController::class, 'update']);
});

Route::middleware([Siswa::class])->group(function() {

    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard']);

    // route untuk melihat absen berdasarkan bulan
    Route::post('/siswa/dashboard/bulan', [SiswaController::class, 'bulan']);
    Route::get('/siswa/dashboard/{bulan}', [SiswaController::class, 'month']);

    // route untuk mendownload bukti
    Route::get('/siswa/download/{bukti}/{file}', [SiswaController::class, 'download']);
    Route::get('/siswa/download/', [SiswaController::class, 'back']);

});

Route::middleware([Operator::class])->group(function() {

    Route::get('/operator/dashboard', [OperatorController::class, 'dashboard'])->name('operator');

    // route untuk mengelola kelas
    Route::get('/operator/data-kelas/{id}/hapus', [KelasController::class, 'destroy'])->name('operator.delete');
    Route::get('/operator/data-kelas/{id}/edit', [KelasController::class, 'edit'])->name('operator.edit');
    Route::get('/operator/data-kelas/{id}', [KelasController::class, 'show'])->name('operator.show');
    Route::resource('/operator/data-kelas', KelasController::class, ['names' => 'kelas_operator'])->except('destroy', 'edit', 'show');

    // route untuk mengelola siswa
    Route::get('/operator/data-siswa/{nisn}/hapus', [DataSiswaController::class, 'delete'])->name('data.delete');
    Route::post('/operator/data-siswa/{nisn}/edit', [DataSiswaController::class, 'update'])->name('data.update');
    Route::get('/operator/data-siswa/{nisn}/edit', [DataSiswaController::class, 'edit'])->name('data.edit');
    Route::resource('/operator/data-siswa', DataSiswaController::class, ['names' => 'operator_siswa'])->except('destroy','update', 'edit');

});

Route::middleware([Admin::class])->group(function() {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    // route untuk mengelola kelas
    Route::get('/admin/data-kelas/{id}/hapus', [KelasController::class, 'destroy']);
    Route::get('/admin/data-kelas/{id}/edit', [KelasController::class, 'edit']);
    Route::get('/admin/data-kelas/{id}', [KelasController::class, 'show']);
    Route::resource('/admin/data-kelas', KelasController::class, ['names' => 'kelas_admin'])->except('destroy', 'edit', 'show');

    // Route untuk mengelola siswa
    Route::get('/admin/data-siswa/{nisn}/hapus', [DataSiswaController::class, 'delete']);
    Route::post('/admin/data-siswa/{nisn}/edit', [DataSiswaController::class, 'update']);
    Route::get('/admin/data-siswa/{nisn}/edit', [DataSiswaController::class, 'edit']);
    Route::resource('/admin/data-siswa', DataSiswaController::class, ['names' => 'admin_siswa'])->except('destroy','update', 'edit');

    // route untuk mengelola operator
    Route::resource('admin/kelola-user', KelolaUserController::class,  ['names' => 'admin_operator'])->except('destroy', 'show');
    Route::get('/admin/kelola-user/{id}/hapus', [KelolaUserController::class, 'destroy']);

});



