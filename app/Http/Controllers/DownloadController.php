<?php

namespace App\Http\Controllers;

class DownloadController extends Controller
{
    public function sampel()
    {
        $filePath = public_path('templates/seeder_sampel_template.xlsx');
        return response()->download($filePath);
    }
    public function perusahaan()
    {
        $filePath = public_path('templates/seeder_perusahaan_template.xlsx');
        return response()->download($filePath);
    }
}
