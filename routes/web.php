<?php

use App\Http\Controllers\BebanKerjaController;
use App\Http\Controllers\SearchUser;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\SampelController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\MasterMitraController;
use App\Http\Controllers\MasterOrganikController;
use App\Http\Controllers\MasterPerusahaanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenugasanMitraController;
use App\Http\Controllers\PenugasanPegawaiController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\SearchKegiatan;
use App\Http\Controllers\SearchMitra;
use App\Http\Controllers\TugasPegawaiController;
use App\Models\PenugasanMitra;
use App\Models\PenugasanPegawai;
use App\Models\TugasPegawai;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Tambahan untuk periode dan distribusi kegiatan (jika diperlukan)
Route::get('/dashboard/distribusi-kegiatan', [DashboardController::class, 'distribusiKegiatan'])->name('dashboard.distribusi-kegiatan');
Route::get('/dashboard/beban-kerja-organik', [DashboardController::class, 'bebanKerjaOrganik'])->name('dashboard.beban-kerja-organik');

// AJAX route untuk detail beban kerja organik (jika menggunakan AJAX untuk menampilkan detail)
Route::get('/dashboard/beban-kerja-organik/detail/{id}', [DashboardController::class, 'bebanKerjaDetail'])->name('dashboard.beban-kerja-organik.detail');
Route::get('/login', [MasterOrganikController::class, 'login'])->name('login');
Route::post('/login', [MasterOrganikController::class, 'validateUser'])->name('validateUser');

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'beban-kerja'], function () {
        Route::get('/', [BebanKerjaController::class, 'showAll'])
            ->name('beban-kerja-all'); // organik beda view 
        Route::get('/pengajuan/all', [TugasPegawaiController::class, 'showAll'])
            ->name('pengajuan-all'); // organik beda view
        Route::get('/add', [BebanKerjaController::class, 'create'])
            ->name('beban-kerja-add')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::post('/add/save', [BebanKerjaController::class, 'store'])
            ->name('beban-kerja-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::get('/{id}/penugasan', [BebanKerjaController::class, 'show'])
            ->name('beban-kerja-tugas'); //organik beda view
        Route::delete('/{id}/penugasan/delete', [BebanKerjaController::class, 'delete'])
            ->name('beban-kerja-delete')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::get('/{id}/tugas-organik/{petugas}', [PenugasanPegawaiController::class, 'view'])
            ->name('penugasan-organik-detail'); // organik hanya bisa akses dirinya sendiri
        Route::post('/{id}/tugas-organik/{petugas}/approve/{tugasId}', [PenugasanPegawaiController::class, 'accPenugasan'])
            ->name('penugasan-organik-approve')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::post('/{id}/tugas-organik/{petugas}/tugaskan/{tugasId}', [PenugasanPegawaiController::class, 'accPengajuan'])
            ->name('pengajuan-organik-approve')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::post('/pengajuan/acc/{tugasId}', [PenugasanPegawaiController::class, 'accPengajuanTabel'])
            ->name('pengajuan-organik-approve-tabel')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::get('/{id}/tugas-organik/{petugas}/create', [PenugasanPegawaiController::class, 'createTugas'])
            ->name('pengumpulan-tugas-organik-create');
        Route::get('{id}/tugas-organik/{petugas}/edit', [PenugasanPegawaiController::class, 'edit'])
            ->name('penugasan-organik-edit')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::get('{id}/tugas-mitra/{petugas}/edit', [PenugasanMitraController::class, 'edit'])
            ->name('penugasan-mitra-edit')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::put('{id}/tugas-mitra/{petugas}/save', [PenugasanMitraController::class, 'update'])
            ->name('penugasan-mitra-edit-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::get('pengumpulan/{tugas}/edit', [PenugasanPegawaiController::class, 'editTugas'])
            ->name('pengumpulan-tugas-organik-edit');
        Route::get('/{id}/tugas-organik/{petugas}/createpengajuan', [PenugasanPegawaiController::class, 'createPengajuan'])
            ->name('pengajuan-tugas-organik-create');
        Route::post('/save-tugas-organik', [PenugasanPegawaiController::class, 'storeTugas'])
            ->name('pengumpulan-tugas-organik-save');
        Route::put('/edit-tugas-organik', [PenugasanPegawaiController::class, 'updateTugas'])
            ->name('pengumpulan-tugas-organik-update');
        Route::get('/{id}/tambah-organik', [PenugasanPegawaiController::class, 'create'])
            ->name('penugasan-organik-create')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::post('{id}/tambah-organik/save', [PenugasanPegawaiController::class, 'store'])
            ->name('penugasan-organik-create-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::put('{id}/penugasan/{pegawai}/update', [PenugasanPegawaiController::class, 'update'])
            ->name('penugasan-organik-update')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::put('/tugas-organik/edit/{id}', [PenugasanPegawaiController::class, 'update'])
            ->name('penugasan-organik-edit-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
        Route::delete('{penugasan}/penugasan/organik/delete/{id}', [PenugasanPegawaiController::class, 'delete'])
            ->name('penugasan-organik-delete');
        Route::delete('tugas-organik/delete/{id}', [PenugasanPegawaiController::class, 'deleteTugas'])->name('pengumpulan-tugas-delete');

        Route::delete('{penugasan}/penugasan/mitra/delete/{id}', [PenugasanMitraController::class, 'delete'])
            ->name('penugasan-mitra-delete')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim,Organik");
        Route::get('/{id}/tambah-mitra', [PenugasanMitraController::class, 'create'])
            ->name('penugasan-mitra-create')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim,Organik");
        Route::post('/{id}/tambah-mitra/save', [PenugasanMitraController::class, 'store'])
            ->name('penugasan-mitra-create-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim,Organik");
        Route::get('/tugas-mitra/edit/{id}', [PenugasanMitraController::class, 'edit'])
            ->name('penugasan-mitra-edit-view')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim,Organik");
        Route::put('/{id}/tugas-mitra/edit/{pegawai}', [PenugasanMitraController::class, 'update'])
            ->name('penugasan-mitra-edit-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim,Organik");
        Route::get('/organik', [PenugasanPegawaiController::class, 'index'])
            ->name('beban-kerja-organik');
        Route::get('/mitra', [PenugasanMitraController::class, 'index'])
            ->name('beban-kerja-mitra');
        Route::post('/logout', [MasterOrganikController::class, 'logout'])->name('logout');
        Route::get('/search/pegawai', [SearchUser::class, 'search'])->name("search-pegawai");
    });

    Route::group(['prefix' => 'manajemen-sampel'], function () {
        Route::get('/', [SampelController::class, 'index'])
            ->name('sampel-all');
        Route::get('/create', [SampelController::class, 'create'])
            ->name('sampel-create');
        Route::post('/generate', [SampelController::class, 'generate'])
            ->name('sampel-generate');
        Route::get('/detail/{id}', [SampelController::class, 'show'])
            ->name('sampel-detail');
    });

    // Manajemen User
    Route::get('/manajemen-user/create', [MasterOrganikController::class, 'createUser'])
        ->name('manajemen-user-create')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");
    Route::post('/manajemen-user/create', [MasterOrganikController::class, 'storeUser'])
        ->name('manajemen-user-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");
    Route::get('/manajemen-user/edit/{id}', [MasterOrganikController::class, 'editUser'])
        ->name('manajemen-user-edit')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");
    Route::put('/manajemen-user/update/{id}', [MasterOrganikController::class, 'updateUser'])
        ->name('manajemen-user-edit-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");
    Route::get('/manajemen-user', [MasterOrganikController::class, 'indexUser'])
        ->name('manajemen-user')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
    Route::delete('/manajemen-user/delete/{id}', [MasterOrganikController::class, 'deleteUser'])
        ->name('manajemen-user-delete')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");


    // Master organik
    Route::get('/master-organik', [MasterOrganikController::class, 'index'])
        ->name('master-organik')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
    Route::get('/master-organik/create', [MasterOrganikController::class, 'create'])
        ->name('master-organik-create')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
    Route::get('/master-organik/edit/{id}', [MasterOrganikController::class, 'edit'])
        ->name('master-organik-edit')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
    Route::post('/master-organik/save', [MasterOrganikController::class, 'store'])
        ->name('master-organik-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan,Ketua Tim");
    Route::put('/master-organik/update/{id}', [MasterOrganikController::class, 'update'])
        ->name('master-organik-edit-save')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");
    Route::delete('/master-organik/delete/{id}', [MasterOrganikController::class, 'delete'])
        ->name('master-organik-delete')->middleware(RoleMiddleware::class . ":Admin Kabupaten,Pimpinan");


    Route::get('/mitra', [MasterMitraController::class, 'index'])
        ->name('master-mitra');
    Route::get('/mitra/create', [MasterMitraController::class, 'create'])
        ->name('master-mitra-create-view');
    Route::post('/mitra/create', [MasterMitraController::class, 'store'])
        ->name('master-mitra-create-save');
    Route::get('/mitra/edit/{id}', [MasterMitraController::class, 'edit'])
        ->name('master-mitra-edit-view');
    Route::put('/mitra/edit/{id}', [MasterMitraController::class, 'update'])
        ->name('master-mitra-edit-save');
    Route::delete('/mitra/delete/{id}', [MasterMitraController::class, 'delete'])
        ->name('master-mitra-delete');


    Route::get('/master-mitra', [MasterMitraController::class, 'index'])->name('master-mitra');
    Route::get('/master-mitra/create', [MasterMitraController::class, 'create'])->name('master-mitra-create-view');
    Route::post('/master-mitra/store', [MasterMitraController::class, 'store'])->name('master-mitra-store');
    Route::get('/master-mitra/edit/{id}', [MasterMitraController::class, 'edit'])->name('master-mitra-edit-view');
    Route::post('/master-mitra/update/{id}', [MasterMitraController::class, 'update'])->name('master-mitra-update');
    Route::delete('/master-mitra/delete/{id}', [MasterMitraController::class, 'delete'])->name('master-mitra-delete');
    Route::get('/master-mitra/tambahfile', [MasterMitraController::class, 'showUploadForm'])->name('master-mitra-tambahfile');
    Route::post('/master-mitra/import', [MasterMitraController::class, 'import'])->name('master-mitra-import');
    // Rute untuk menampilkan form upload file
    Route::get('/master-mitra/tambahfile', [MasterMitraController::class, 'showUploadForm'])->name('master-mitra-tambahfile');

    // Rute untuk memproses file Excel yang diupload
    Route::post('/master-mitra/import', [MasterMitraController::class, 'import'])->name('import-mitra');

    // Rute untuk menghapus mitra
    Route::delete('/master-mitra/delete/{id}', [MasterMitraController::class, 'delete'])->name('master-mitra-delete');

    Route::get('/perusahaan/all', [PerusahaanController::class, 'index'])
        ->name('perusahaan-all');
    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan.index');
    Route::get('/perusahaan/create', [PerusahaanController::class, 'create'])->name('perusahaan.create');
    Route::post('/perusahaan', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/perusahaan/{id}/edit', [PerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::put('/perusahaan/{id}', [PerusahaanController::class, 'update'])->name('perusahaan.update');
    Route::delete('/perusahaan/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.destroy');



    // Rute Dashboard
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
