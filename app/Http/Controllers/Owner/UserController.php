<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return view('owner.user.index', compact('users'));
    }

    public function create()
    {
        return view('owner.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('owner.user.index')
            ->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Pastikan hanya bisa edit akun admin
        if ($user->role !== 'admin') {
            abort(403, 'Tidak dapat mengedit akun owner.');
        }

        return view('owner.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('owner.user.index')
            ->with('success', 'Akun admin berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'admin') {
            abort(403, 'Tidak dapat menghapus akun owner.');
        }

        $user->delete();

        return redirect()->route('owner.user.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}