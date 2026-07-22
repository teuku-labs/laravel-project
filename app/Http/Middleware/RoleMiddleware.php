<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Penggunaan: middleware('role:admin') atau middleware('role:admin,kaprodi')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // Cek apakah role user ada di daftar yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Redirect ke dashboard yang sesuai dengan rolenya
            return redirect($this->getDashboardByRole($userRole))
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }

    private function getDashboardByRole(string $role): string
    {
        return match ($role) {
            'admin'     => route('admin.dashboard'),
            'mahasiswa' => route('mahasiswa.dashboard'),
            'dosen'     => route('dosen.dashboard'),
            'kaprodi'   => route('kaprodi.dashboard'),
            'dekan'     => route('dekan.dashboard'),
            default     => route('login'),
        };
    }
}