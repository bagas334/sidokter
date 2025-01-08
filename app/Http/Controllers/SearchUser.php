<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class SearchUser extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = Pegawai::where('nip', 'LIKE', "%{$query}%")
            ->orWhere('nip_bps', 'LIKE', "%{$query}%")
            ->orWhere('nama', 'LIKE', "%{$query}%")
            ->orWhere('alias', 'LIKE', "%{$query}%")
            ->orWhere('jabatan', 'LIKE', "%{$query}%")
            ->get();
        return response()->json($users);
    }
}
