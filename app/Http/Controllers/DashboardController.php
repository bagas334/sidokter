<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Mitra;
use App\Models\Pegawai;
use App\Models\PenugasanPegawai;

class DashboardController extends Controller
{
    public function index()
    {
        $kegiatan_periode = Kegiatan::countByMonth();
        $kegiatan_periode_labels = $kegiatan_periode['label'];
        $kegiatan_periode_value = $kegiatan_periode['jumlah'];

        $kegiatan_organik = Pegawai::getTugasPegawai();
        $kegiatan_organik_labels = $kegiatan_organik['nama'];
        $kegiatan_organik_value = $kegiatan_organik['tugas'];

        $kegiatan_fungsi_data = Kegiatan::countByAsalFungsi();
        $kegiatan_fungsi_labels = $kegiatan_fungsi_data->keys()->toArray();
        $kegiatan_fungsi_value = $kegiatan_fungsi_data->values()->toArray();

        $kegiatan_user = PenugasanPegawai::getAllByUserId(env('SESSION_USER_ID'));
        $kegiatan_user = $kegiatan_user->map(function($item) {
            return (object) [
                'id' => $item->id,
                'nama_tugas' => $item->nama_kegiatan,
                'nama_pemberi_tugas' => $item->nama_pemberi_tugas,
                'tanggal_penugasan' => $item->tanggal_penugasan,
                'status' => $item->status
            ];
        });

        $jumlah_kegiatan_user = count($kegiatan_user);

        return view('dashboard', [
            'kegiatan_periode_labels' => $kegiatan_periode_labels,
            'kegiatan_periode_value' => $kegiatan_periode_value,
            'kegiatan_organik_labels' => $kegiatan_organik_labels,
            'kegiatan_organik_value' => $kegiatan_organik_value,
            'kegiatan_fungsi_labels' => $kegiatan_fungsi_labels,
            'kegiatan_fungsi_value' => $kegiatan_fungsi_value,
            'kegiatan_user' => $kegiatan_user,
            'jumlah_kegiatan_user' => $jumlah_kegiatan_user
        ]);
    }

}
