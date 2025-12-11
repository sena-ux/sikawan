<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\UserManajementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(PegawaiController::class)->group(function () {
        Route::get('/pegawai', 'index')->name('pegawai');
        Route::post('/pegawai/import', 'import')->name('pegawai.import');
        Route::get('/pegawai/data', 'getData')->name('pegawai.data');
        Route::get('/pegawai/{id}/edit', 'edit')->name('pegawai.edit');
        Route::put('/pegawai/{id}/update', 'update')->name('pegawai.update');
        Route::delete('/pegawai/{id}/delete', 'destroy')->name('pegawai.destroy');
    });

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/masuk', [AbsensiController::class, 'checkIn'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'checkOut'])->name('absensi.pulang');
    Route::post('/absensi/izin', [AbsensiController::class, 'izin'])->name('absensi.izin');
    Route::get('/absensi/izin/request', [AbsensiController::class, 'izinRequest'])->name('absensi.izin.request');
    Route::get('/absensi/izin/request/{id}/detail', [AbsensiController::class, 'izinRequestDetail'])->name('absensi.izin.request.detail');
    Route::post('/absensi/izin/request/{id}/approve', [AbsensiController::class,'approveIzinRequest'])->name('absensi.izin.request.approve');
    Route::get('/absensi/data', [AbsensiController::class, 'absensiData'])->name('absensi.data');
    Route::get('/absensi/get/data', [AbsensiController::class, 'absensiGetData'])->name('absensi.get.data');

    Route::controller(JurnalController::class)->group(function () {
        Route::get('jurnal', 'index')->name('main.jurnal');
        Route::post('jurnal/simpan', 'simpan')->name('simpan.jurnal');
        Route::get('jurnal/data', 'getData')->name('jurnal.data');
        Route::get('jurnal/{id}/edit', 'edit')->name('jurnal.edit');
        Route::put('jurnal/{id}/update', 'update')->name('jurnal.update');
        Route::delete('jurnal/{id}/delete', 'destroy')->name('jurnal.destroy');
        Route::get('jurnal/manage-data', 'manageData')->name('jurnal.manage.data');
        Route::get('jurnal/get-data', 'getDataWhere')->name('jurnal.get.data');
        Route::get('jurnal/get-data/{id}/detail', 'getOne')->name('jurnal.get.one');
    });

    Route::controller(UserManajementController::class)->group(function () {
        Route::get('user-management', 'index')->name('user.management');
        Route::get('user-management/data', 'getData')->name('user.management.data');
        Route::post('user-management/store', 'store')->name('user.management.store');
        Route::get('user-management/{id}/edit', 'edit')->name('user.management.edit');
        Route::put('user-management/{id}/update', 'update')->name('user.management.update');
        Route::post('user-management/updateRole', 'updateRole')->name('user.management.updateRole');
        Route::post('user-management/resetPassword', 'resetPassword')->name('user.management.resetPassword');
        Route::delete('user-management/{id}/delete', 'destroy')->name('user.management.destroy');
    });

    Route::controller(LaporanController::class)->group(function () {
        Route::get('laporan', 'index')->name('main.laporan');
        Route::get('laporan/view', 'view')->name('laporan.view');
        Route::get('laporan/data','data')->name('laporan.data');
        Route::get('laporan/generate-data','generateData')->name('laporan.generate.data');
    });

    Route::get('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('register/post', [AuthController::class, 'register'])->name('register.post');
});
