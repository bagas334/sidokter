<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user(); // Ambil pengguna yang sedang login

        // Periksa apakah user memiliki jabatan yang sesuai
        if (!$user || !in_array($user->jabatan, $roles)) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
