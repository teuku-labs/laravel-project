<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter; // FIX: untuk brute-force protection
use App\Models\User;

class SesiController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nim_nuptk' => 'required',
            'password'  => 'required'
        ], [
            'nim_nuptk.required' => 'NIM / NUPTK wajib diisi',
            'password.required'  => 'Password wajib diisi'
        ]);

        // FIX: rate limit percobaan login (5x per menit per kombinasi NIM+IP)
        $throttleKey = strtolower($request->nim_nuptk) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'login' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ])->onlyInput('nim_nuptk');
        }

        $user = User::where('nim_nuptk', $request->nim_nuptk)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            RateLimiter::clear($throttleKey);

            Auth::login($user);
            $request->session()->regenerate();

            // FIX: sebelumnya kaprodi & dekan tidak ditangani sama sekali,
            // sehingga selalu jatuh ke "Role tidak dikenali" dan logout paksa.
            $dashboard = match ($user->role) {
                'admin'     => 'admin.dashboard',
                'mahasiswa' => 'mahasiswa.dashboard',
                'dosen'     => 'dosen.dashboard',
                'kaprodi'   => 'kaprodi.dashboard',
                'dekan'     => 'dekan.dashboard',
                default     => null,
            };

            if ($dashboard) {
                return redirect()->route($dashboard);
            }

            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['login' => 'Role tidak dikenali']);
        }

        RateLimiter::hit($throttleKey, 60); // FIX: catat percobaan gagal, kunci 60 detik setelah 5x gagal

        return back()->withErrors([
            'login' => 'NIM / NUPTK dan password tidak sesuai'
        ])->onlyInput('nim_nuptk');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}