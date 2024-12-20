<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class MasterMitraController extends Controller
{
    public function index()
    {
        $mitra = Mitra::paginate(25);
        return view('master-mitra', compact('mitra'));
    }

    public function create()
    {
        $wilayah = Wilayah::select('kecamatan', 'kelurahan')
            ->get()
            ->groupBy('kecamatan')
            ->map(function ($group) {
                return $group->pluck('kelurahan')->toArray();
            })
            ->toArray();

        return view('master-mitra-create', compact('wilayah'));
    }

    public function store(Request $request)
    {
        if(is_array($request->get('posisi'))) {
            $request->merge(['posisi' => implode(',', $request->get('posisi'))]);
        } elseif ($request->get('posisi') === '') {
            $request->merge(['posisi' => null]);
        }

        Mitra::create($request->except('_token', '_method'));
        return redirect()->route('master-mitra');
    }

    public function edit($id)
    {
        $mitra = Mitra::find($id);

        if ($mitra->posisi) {
            $mitra->posisi = explode(',', $mitra->posisi);
        } else {
            $mitra->posisi = [];
        }

        $wilayah = Wilayah::select('kecamatan', 'kelurahan')
            ->get()
            ->groupBy('kecamatan')
            ->map(function ($group) {
                return $group->pluck('kelurahan')->toArray();
            })
            ->toArray();

        return view('master-mitra-edit', compact('mitra', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        if(is_array($request->get('posisi'))) {
            $request->merge(['posisi' => implode(',', $request->get('posisi'))]);
        } elseif ($request->get('posisi') === '') {
            $request->merge(['posisi' => null]);
        }

        Mitra::where('id', $id)->update($request->except('_token', '_method'));

        return redirect()->route('master-mitra');
    }

    public function delete($id)
    {
        Mitra::find($id)->delete();
        return redirect()->route('master-mitra');
    }
}
