<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // Catat gagal login
            AuditLog::create([
   						 'user_id' => null,
   						 'nama' => null,
  						  'email' => $request->email,
    'role' => null,
    'aksi' => 'LOGIN_GAGAL',
    'modul' => 'AUTH',
    'keterangan' => 'Percobaan login gagal untuk email: ' . $request->email,
    'ip_address' => AuditLog::getClientIp($request),
    'user_agent' => $request->userAgent(),
    'lokasi' => AuditLog::getLocationText($request),
    'browser' => AuditLog::getBrowser($request->userAgent()),
    'os' => AuditLog::getOS($request->userAgent()),
    'waktu' => now(),
					]);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Catat berhasil login
        AuditLog::catat('LOGIN', 'Berhasil login ke sistem', $user);

        return $this->redirectByRole($user);
    }

    public function logout(Request $request)
    {
        // Catat logout sebelum session dihapus
        AuditLog::catat('LOGOUT', 'Keluar dari sistem');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'owner' => redirect()->route('owner.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali.']),
        };
    }
}