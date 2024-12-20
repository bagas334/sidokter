<?php

namespace Database\Factories;

use App\Models\Mitra;
use Illuminate\Database\Eloquent\Factories\Factory;

class MitraFactory extends Factory
{
    protected $model = Mitra::class;

    public function definition()
    {
        return [
            'sobat_id' => $this->faker->numberBetween(1, 100),
            'nama' => $this->faker->name,
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'email' => $this->faker->unique()->safeEmail,
            'kecamatan' => $this->faker->city,
            'kelurahan' => $this->faker->citySuffix,
            'alamat_detail' => $this->faker->address,
            'posisi' => $this->faker->word,
            'pendapatan' => $this->faker->randomDigitNotZero(100000, 4000000),
        ];
    }
}
