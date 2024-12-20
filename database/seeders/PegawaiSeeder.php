<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan factory untuk membuat 10 data Pegawai
        Pegawai::factory()->count(10)->create();
    }
}
