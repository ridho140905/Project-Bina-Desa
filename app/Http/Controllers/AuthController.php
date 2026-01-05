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
    // ===== VALIDATE (SATU SAJA) =====
    $request->validate([
        'email'    => 'required',
        'password' => 'required',
    ], [
        'email.required'    => 'Email / Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
    ]);

    $email    = $request->email;
    $password = $request->password;

    // ---------- FMI => ADMIN ----------
    if ($email === 'fmi' && $password === 'fmi') {
        $user = User::where('role', 'Admin')->first();
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            session([
                'user_id' => $user->id,
                'username' => $user->name,
                'user_profile_picture' => $user->profile_picture
            ]);

            return redirect('dashboard')
                ->with('success', 'Login Admin (FMI) berhasil!');
        }
    }

    // ---------- HMN & FMIHMN => GUEST ----------
    if (
        ($email === 'hmn' && $password === 'hmn') ||
        ($email === 'fmihmn' && $password === 'fmihmn')
    ) {
        $user = User::where('role', 'Guest')->first();
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            session([
                'user_id' => $user->id,
                'username' => $user->name,
                'user_profile_picture' => $user->profile_picture
            ]);

            return redirect('dashboard')
                ->with('success', 'Login Guest berhasil!');
        }
    }

    // ---------- LOGIN NORMAL ----------
    $user = User::where('email', $email)->first();

    if ($user && Hash::check($password, $user->password)) {
        Auth::login($user);
        $request->session()->regenerate();

        session([
            'user_id' => $user->id,
            'username' => $user->name,
            'user_profile_picture' => $user->profile_picture
        ]);

        return redirect('dashboard')
            ->with('success', 'Login berhasil!');
    }

    return back()->with('error', 'Email / Username atau password salah!');
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
            'role'     => 'required', // Tambahkan validasi untuk role
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // ← OPSIONAL: tambah validasi untuk gambar
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
            'profile_picture.image' => 'File harus berupa gambar.',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Data user baru
        $userData = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ];

        // Handle upload profile picture jika ada
        if ($request->hasFile('profile_picture')) {
            $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $request->file('profile_picture')->storeAs('public/profile_pictures', $fileName);
            $userData['profile_picture'] = $fileName;
        }

        // Create user baru
        $user = User::create($userData);

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
