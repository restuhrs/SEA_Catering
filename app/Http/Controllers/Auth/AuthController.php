<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Register
    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'
            ],
            'email' => 'required|email|unique:users',
            'password' => [
                'required', 'min:8',
                'regex:/[a-z]/',    // lowercase
                'regex:/[A-Z]/',    // uppercase
                'regex:/[0-9]/',    // digit
                'regex:/[@$!%*?&#]/' // special
            ],
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('success', 'Account successfully created. You can now login.');
    }

    // Login
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Ambil kredensial login dari input
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Cek apakah user dengan email tersebut ada di model db_user
        $user = User::where('email', $request->email)->first();

        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan user ke session Laravel
            Auth::login($user);
            $request->session()->regenerate(); // Regenerate session ID

            // Cek role pengguna dan arahkan ke halaman dashboard yang sesuai
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'customer') {
                return redirect()->route('home');
            } else {
                dd('Role unauthorized:', $user->role);
            }
        }

        // Jika login gagal, kirim pesan error dan arahkan kembali
        return redirect()->back()->withInput()->withErrors(['password_invalid' => 'Email or password invalid']);  // Tampilkan error jika login gagal
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
