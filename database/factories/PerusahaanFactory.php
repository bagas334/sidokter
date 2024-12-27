<?php

namespace Database\Factories;

use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerusahaanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Perusahaan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idsbr' => $this->faker->unique()->numerify('IDSBR####'),
            'kode_wilayah' => $this->faker->numerify('WIL####'),
            'nama_usaha' => $this->faker->company,
            'sls' => $this->faker->numerify('SLS###'),
            'alamat_detail' => $this->faker->address,
            'kode_kbli' => $this->faker->numerify('KBLI###'),
            'nama_cp' => $this->faker->name,
            'nomor_cp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
