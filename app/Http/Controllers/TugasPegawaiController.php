<?php

namespace App\Http\Controllers;

use App\Models\TugasPegawai;
use Illuminate\Http\Request;

class TugasPegawaiController extends Controller
{
    public function show($id)
    {
        if (in_array(auth()->user()->jabatan, ['Admin Kabupaten', 'Pimpinan'])) {
            $tugas_pegawai = TugasPegawai::where('id', $id);
        }
        return view('penugasan-detail-organik', compact('tugas_pegawai'));
    }

    public function showAll()
    {
        if (auth()->user()->jabatan == 'Ketua Tim') {
            $tugas_pegawai = TugasPegawai::with([
                'penugasanPegawai.pegawai',
                'penugasanPegawai.kegiatan'
            ])
                ->where('status', 'diajukan')
                ->whereHas('penugasanPegawai.kegiatan', function ($query) {
                    $query->where('asal_fungsi', auth()->user()->fungsi_ketua_tim);
                })
                ->get();
        } else {
            $tugas_pegawai = TugasPegawai::with([
                'penugasanPegawai.pegawai',
                'penugasanPegawai.kegiatan'
            ])->where('status', 'diajukan')->get();
        }

        return view('pengajuan', compact('tugas_pegawai'));
    }
}
