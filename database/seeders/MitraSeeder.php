<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitra;

class MitraSeeder extends Seeder
{
    public function run()
    {
        Mitra::factory()->count(10)->create();
    }
}
