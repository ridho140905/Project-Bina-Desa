<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display login form
     */
    public function index()
    {
       if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('pages.auth.form-login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input form login
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cek credentials di database
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Gunakan Auth::login() untuk login dengan Laravel Auth System
            Auth::login($user);

            // Simpan session tambahan jika diperlukan
            session(['user_id' => $user->id, 'username' => $user->name]);

            // Redirect ke dashboard dengan flash message
            return redirect('dashboard')->with('success', 'Selamat Datang ke halaman dashboard');
        }

        // Jika gagal login
        return back()->with('error', 'Email atau password salah!');
    }

    /**
     * Tampilkan halaman register (GET)
     */
    public function showRegister()
    {
        return view('pages.auth.form-register');
    }

    /**
     * Proses pendaftaran (POST)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required' // Tambahkan validasi untuk role
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'name.min'           => 'Nama minimal 3 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
        ]);

        // Create user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        if ($user) {
            // Jika berhasil
            return redirect()
                ->route('auth.index')
                ->with('success', 'Registrasi berhasil! Silakan login.');
        } else {
            // Jika gagal
            return redirect()
                ->route('auth.showRegister')
                ->with('error', 'Registrasi gagal. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();      // Hapus semua session
        $request->session()->regenerateToken(); // Cegah CSRF

        return redirect()->route('auth.index')->with('success', 'Anda telah logout!');
    }

    // Method lainnya tetap sama...
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
