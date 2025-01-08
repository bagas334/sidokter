<?php

namespace App\Imports;

use App\Models\Mitra;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MitraImport implements ToModel, WithHeadingRow
{
    /**
     * Memasukkan data dari file Excel ke database tabel `mitra`.
     *
     * @param array $row Baris dari file Excel
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Mitra([
            'sobat_id' => $row['sobat_id'], // Kolom sobat_id pada file Excel
            'nama' => $row['nama'],         // Kolom nama pada file Excel
            'email' => $row['email'],       // Kolom email pada file Excel
            'posisi' => $row['posisi'],     // Kolom posisi pada file Excel
            'kecamatan' => $row['kecamatan'], // Kolom kecamatan pada file Excel
            'kelurahan' => $row['kelurahan'], // Kolom kelurahan pada file Excel
            'alamat_detail' => $row['alamat_detail'], // Kolom alamat_detail pada file Excel
            'fungsi' => $row['fungsi'],     // Kolom fungsi pada file Excel
            'pendapatan' => $row['pendapatan'], // Kolom pendapatan pada file Excel
        ]);
    }
}
