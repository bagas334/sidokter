<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    public function definition()
    {
        return [
            'nip' => $this->faker->unique()->randomNumber(9, true), // NIP sebagai angka acak 9 digit
            'nip_bps' => $this->faker->unique()->randomNumber(6, true), // NIP BPS sebagai angka acak 6 digit
            'nama' => $this->faker->name, // Nama pegawai
            'alias' => $this->faker->optional()->word, // Alias (nullable)
            'jabatan' => $this->faker->randomElement(['Ketua Tim', 'Admin', 'Organik', 'Pimpinan']),
            'fungsi_ketua_tim' => $this->faker->randomElement(['Statistik Produksi', 'Nerwilis', 'IPDS']),
        ];
    }
}
