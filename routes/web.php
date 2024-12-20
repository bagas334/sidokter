<?php

use App\Http\Controllers\BebanKerjaController;
use App\Http\Controllers\BebanKerjaMitraController;
use App\Http\Controllers\BebanKerjaOrganikController;
use App\Http\Controllers\CapaianAgregatController;
use App\Http\Controllers\CapaianOrganikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ManajemenSampelController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\MasterMitraController;
use App\Http\Controllers\MasterOrganikController;
use App\Http\Controllers\MasterPerusahaanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenugasanMitraController;
use App\Http\Controllers\PenugasanPegawaiController;
use App\Http\Controllers\TugasPegawaiController;
use App\Models\PenugasanMitra;
use App\Models\PenugasanPegawai;
use App\Models\TugasPegawai;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/login', [MasterOrganikController::class, 'login'])->name('login');

Route::group(['prefix' => 'capaian'], function () {
    Route::get('/agregat', [CapaianAgregatController::class, 'index'])
        ->name('capaian-agregat');
    Route::get('/organik', [CapaianOrganikController::class, 'index'])
        ->name('capaian-organik');
    Route::get('/organik/{nama}', [CapaianOrganikController::class, 'showDetail'])
        ->name('capaian-organik-detail');
    Route::get('/organik/mitra/{nama}', [CapaianOrganikController::class, 'showMitra'])
        ->name('capaian-organik-mitra');
});

Route::group(['prefix' => 'beban-kerja'], function () {
    Route::get('/', [BebanKerjaController::class, 'showAll'])
        ->name('beban-kerja-all');
    Route::get('/pengajuan/all', [TugasPegawaiController::class, 'showAll'])
        ->name('pengajuan-all');
    Route::get('/add', [BebanKerjaController::class, 'create'])
        ->name('beban-kerja-add');
    Route::post('/add/save', [BebanKerjaController::class, 'store'])
        ->name('beban-kerja-save');
    Route::get('/{id}/penugasan', [BebanKerjaController::class, 'show'])
        ->name('beban-kerja-tugas');
    Route::delete('/{id}/penugasan/delete', [BebanKerjaController::class, 'delete'])
        ->name('beban-kerja-delete');
    Route::get('/{id}/tugas-organik/{petugas}', [PenugasanPegawaiController::class, 'view'])
        ->name('penugasan-organik-detail');
    Route::post('/{id}/tugas-organik/{petugas}/approve/{tugasId}', [PenugasanPegawaiController::class, 'accPenugasan'])
        ->name('penugasan-organik-approve');
    Route::post('/{id}/tugas-organik/{petugas}/tugaskan/{tugasId}', [PenugasanPegawaiController::class, 'accPengajuan'])
        ->name('pengajuan-organik-approve');
    Route::post('/pengajuan/acc/{tugasId}', [PenugasanPegawaiController::class, 'accPengajuanTabel'])
        ->name('pengajuan-organik-approve-tabel');
    Route::get('/{id}/tugas-organik/{petugas}/create', [PenugasanPegawaiController::class, 'createTugas'])
        ->name('pengumpulan-tugas-organik-create');
    Route::get('{id}/tugas-organik/{petugas}/edit', [PenugasanPegawaiController::class, 'edit'])
        ->name('penugasan-organik-edit');
    Route::get('/{id}/tugas-organik/{petugas}/createpengajuan', [PenugasanPegawaiController::class, 'createPengajuan'])
        ->name('pengajuan-tugas-organik-create');
    Route::post('/save-tugas-organik', [PenugasanPegawaiController::class, 'storeTugas'])
        ->name('pengumpulan-tugas-organik-save');
    Route::get('/{id}/tambah-organik', [PenugasanPegawaiController::class, 'create'])
        ->name('penugasan-organik-create');
    Route::post('{id}/tambah-organik/save', [PenugasanPegawaiController::class, 'store'])
        ->name('penugasan-organik-create-save');
    Route::put('{id}/penugasan/{pegawai}/update', [PenugasanPegawaiController::class, 'update'])
        ->name('penugasan-organik-update');
    Route::put('/tugas-organik/edit/{id}', [PenugasanPegawaiController::class, 'update'])
        ->name('penugasan-organik-edit-save');
    Route::delete('{penugasan}/penugasan/organik/delete/{id}', [PenugasanPegawaiController::class, 'delete'])
        ->name('penugasan-organik-delete');
    Route::delete('{penugasan}/penugasan/mitra/delete/{id}', [PenugasanMitraController::class, 'delete'])
        ->name('penugasan-mitra-delete');

    Route::get('/tugas-mitra/show/{id}', [PenugasanMitraController::class, 'show'])
        ->name('penugasan-mitra-detail');
    Route::get('/{id}/tambah-mitra', [PenugasanMitraController::class, 'create'])
        ->name('penugasan-mitra-create');
    Route::post('/{id}/tambah-mitra/save', [PenugasanMitraController::class, 'store'])
        ->name('penugasan-mitra-create-save');
    Route::get('/tugas-mitra/edit/{id}', [PenugasanMitraController::class, 'edit'])
        ->name('penugasan-mitra-edit-view');
    Route::put('/tugas-mitra/edit/{id}', [PenugasanMitraController::class, 'update'])
        ->name('penugasan-mitra-edit-save');
    Route::get('/organik', [PenugasanPegawaiController::class, 'index'])
        ->name('beban-kerja-organik');
    Route::get('/mitra', [PenugasanMitraController::class, 'index'])
        ->name('beban-kerja-mitra');
});

Route::group(['prefix' => 'manajemen-sampel'], function () {
    Route::get('/', [ManajemenSampelController::class, 'index'])
        ->name('sampel-index');
    Route::get('/details/{id}', [ManajemenSampelController::class, 'show'])
        ->name('sampel-show');

    Route::get('/edit/{id}', [ManajemenSampelController::class, 'edit'])
        ->name('sampel-edit-view');
    Route::put('/edit/{id}', [ManajemenSampelController::class, 'update'])
        ->name('sampel-edit-save');
    Route::post('/seeder/{id}', [ManajemenSampelController::class, 'seeder'])
        ->name('sampel-seeder');

    Route::get('/finalisasi/{id}', [ManajemenSampelController::class, 'finalisasi'])
        ->name('kegiatan-finalisasi');
    //
    //    Route::get('/assign/{id}', [ManajemenSampelController::class, 'assign'])
    //        ->name('sampel-assign-view');
    //    Route::post('/create', [ManajemenSampelController::class, 'store'])
    //        ->name('sampel-create-save');

    //    Route::delete('/delete/{id}', [ManajemenSampelController::class, 'delete'])
    //        ->name('sampel-delete');

});

Route::get('/manajemen-user-x', [MasterOrganikController::class, 'index'])
    ->name('master-organik');
Route::get('/manajemen-user', [MasterOrganikController::class, 'index'])
    ->name('manajemen-user');
Route::get('/manajemen-user/create', [MasterOrganikController::class, 'create'])
    ->name('manajemen-user-create');
Route::post('/manajemen-user/create', [MasterOrganikController::class, 'store'])
    ->name('manajemen-user-save');
Route::get('/manajemen-user/edit/{id}', [MasterOrganikController::class, 'edit'])
    ->name('master-organik-edit-view');
Route::put('/manajemen-user/edit/{id}', [MasterOrganikController::class, 'update'])
    ->name('master-organik-edit-save');
Route::delete('/manajemen-user/delete/{id}', [MasterOrganikController::class, 'delete'])
    ->name('master-organik-delete');

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


Route::resource('perusahaan', MasterPerusahaanController::class)
    ->except(['show'])
    ->names([
        'index' => 'perusahaan-index',
        'create' => 'perusahaan-create-view',
        'store' => 'perusahaan-create-save',
        'edit' => 'perusahaan-edit-view',
        'update' => 'perusahaan-edit-save',
        'destroy' => 'perusahaan-destroy',
    ])->parameters([
        'perusahaan' => 'id'
    ]);
Route::post('/perusahaan/seeder', [MasterPerusahaanController::class, 'seeder'])
    ->name('perusahaan-seeder');


Route::group(['prefix' => 'template'], function () {
    Route::get('/seeder-sampel', [DownloadController::class, 'sampel'])
        ->name('template-sampel');
    Route::get('/seeder-perusahaan', [DownloadController::class, 'perusahaan'])
        ->name('template-perusahaan');
});
