<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MasterPerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::getAllWithWilayah();
        return view('menu-master.perusahaan.index', compact('perusahaan'));
    }

    public function create()
    {
        $wilayah = Wilayah::getWilayahGrouped();
        return view('menu-master.perusahaan.create', compact('wilayah'));
    }

    public function store(Request $request)
    {
        $kelurahan = $request->input('kelurahan');
        $kecamatan = $request->input('kecamatan');
        $kode = null;

        if ($kelurahan && $kecamatan) {
            $kode = Wilayah::getKodeWilayahByKecamatanKelurahan($kecamatan, $kelurahan);
        }

        $request->merge(['kode_wilayah' => $kode]);

        Perusahaan::create($request->except(['_token','_method', 'kecamatan', 'kelurahan']));
        return redirect()->route('perusahaan-index');
    }

    public function edit($id)
    {
        $perusahaan = DB::table('perusahaan')
            ->join('wilayah', 'perusahaan.kode_wilayah', '=', 'wilayah.kode')
            ->select('perusahaan.*', 'wilayah.*')
            ->where('perusahaan.id', $id)
            ->first();

        $wilayah = Wilayah::select('kecamatan', 'kelurahan')
            ->get()
            ->groupBy('kecamatan')
            ->map(function ($group) {
                return $group->pluck('kelurahan')->toArray();
            })
            ->toArray();

        return view('master-perusahaan-edit', compact('perusahaan', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        $wilayah = DB::table('wilayah')
            ->where('kecamatan', $request->input('kecamatan'))
            ->where('kelurahan', $request->input('kelurahan'))
            ->first();

        $request->merge(['kode_wilayah' => $wilayah->kode]);

        Perusahaan::find($id)->update($request->except(['_token','_method', 'kecamatan', 'kelurahan']));

        return redirect()->route('master-perusahaan');
    }

    public function delete($id)
    {
        Perusahaan::where('id', $id)->delete();
        return redirect()->route('master-perusahaan');
    }

    public function seeder(Request $request)
    {
        $file_seeder = $request->file('seeder_file');

        $data = Excel::toCollection((object) null, $file_seeder)->first();

        $rows = $data->slice(1);

        foreach ($rows as $row) {
            $kelurahan = $row[3];
            $kecamatan = $row[4];

            $kodeWilayah = Wilayah::getKodeWilayahByKecamatanKelurahan($kecamatan, $kelurahan);

            Perusahaan::create([
                'idsbr' => $row[0],
                'nama_usaha' => $row[1],
                'sls' => $row[2],
                'alamat_detail' => $row[5],
                'kode_kbli' => $row[6],
                'nama_cp' => $row[7],
                'nomor_cp' => $row[8],
                'email' => $row[9],
                'kode_wilayah' => $kodeWilayah
            ]);
        }
        return redirect()->route('perusahaan-index');
    }
}
