<?php

namespace App\Http\Controllers;

use App\Models\M_log_durasi;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }
    
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        // Cek kredensial
        if (Auth::attempt($credentials)) {
            // Regenerate session untuk mencegah session fixation
            $request->session()->regenerate();

            // Simpan waktu login ke dalam session
            $users = Auth::user();
            $loginTime = new DateTime();

            // Create a new session record
            $userSession = M_log_durasi::create([
                'id_pelanggan' => $users->id_pelanggan,
                'login_time' => $loginTime,
                'url' => $request->fullUrl(),
            ]);

            // Simpan session ID dan waktu login ke dalam session
            $request->session()->put('user_session_id', $userSession->id);
            $request->session()->put('login_time', $loginTime);

            return redirect()->intended('/dashboard')->with('loginSuccess', 'Login Berhasil !!');
        }

        // Jika login gagal
        return back()->with('loginError', 'Email / Password salah !');
    }
    
    public function logout(Request $request)
{
    // Cek apakah user sudah login
    if (Auth::check()) {
        // Log page visit
        M_log_durasi::logPageVisit();

        // Logout user
        Auth::logout();
        // Invalidate session
        $request->session()->invalidate();
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Jika user belum login, langsung redirect ke halaman utama
    return redirect('/');
}
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);
        
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => bcrypt($validatedData['password']), // Hash password
        ]);
        
        return redirect('/')->with('success', 'Pendaftaran berhasil! Silahkan login.');
    }
}
