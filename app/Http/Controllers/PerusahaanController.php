<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::paginate(10);
        return view('perusahaan-all', compact('perusahaan'));
    }
}
