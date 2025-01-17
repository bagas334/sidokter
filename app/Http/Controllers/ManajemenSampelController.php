<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Perusahaan;
use App\Models\Sampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenSampelController extends Controller
{
    public function index()
    {
        $ranking = Perusahaan::getTopSampledPerusahaan();
        $kegiatan = Kegiatan::select('id', 'nama', 'banyak_sampel', 'status_sampel')
            ->paginate(25);

        return view('manajemen-sampel.index', compact('ranking', 'kegiatan'));
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::find($id);
        $daftar_sampel = Sampel::getDaftarSampel($id);
        return view('manajemen-sampel.details', compact('kegiatan', 'daftar_sampel'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::find($id);
        $daftar_sampel = Sampel::getDaftarSampel($id)->sortBy('nama_perusahaan');
        $daftar_perusahaan = Perusahaan::all(['id', 'nama_usaha'])
            ->filter(function ($perusahaan) use ($daftar_sampel) {
                return !$daftar_sampel->contains('perusahaan_id', $perusahaan->id);
            })
            ->sortBy('nama_usaha');

        return view('manajemen-sampel.edit', compact('kegiatan', 'daftar_sampel', 'daftar_perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sampel_baru' => 'array',
            'sampel_baru.*' => 'exists:perusahaan,id',
        ]);


        DB::beginTransaction();

        try {
            Sampel::where('kegiatan_id', $id)->delete();

            $sampel_baru = $request->input('sampel_baru', []);

            foreach ($sampel_baru as $perusahaan_id) {
                Sampel::create([
                    'kegiatan_id' => $id,
                    'perusahaan_id' => $perusahaan_id,
                    'dibuat_oleh' => env('SESSION_USER_ID'),
                ]);
            }

            DB::commit();

            return redirect()->route('sampel-index')->with('success', 'Samples updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update samples. Please try again.');
        }
    }

    public function seeder(Request $request, $id)
    {
        Sampel::where('kegiatan_id', $id)->delete();

        $file_seeder = $request->file('seeder_file');
        $idsbrList = Excel::toArray((object)[], $file_seeder);

        $idsbrColumn = $idsbrList[0];
        $idsbrValues = array_column($idsbrColumn, 0);
        array_shift($idsbrValues);

        $perusahaanIds = Perusahaan::whereIn('idsbr', $idsbrValues)->pluck('id', 'idsbr');


        foreach ($idsbrValues as $idsbr) {
            if (isset($perusahaanIds[$idsbr])) {
                Sampel::create([
                    'kegiatan_id' => $id,
                    'perusahaan_id' => $perusahaanIds[$idsbr],
                    'dibuat_oleh' => env('SESSION_USER_ID'),
                ]);
            }
        }

        return redirect()->route('sampel-edit-view', $id);
    }

    public function finalisasi($id)
    {
        return view('dashboard');
    }
}
