<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function index()
    {
        $mekaniks = Mekanik::latest()->paginate(10);
        return view('owner.mekanik.index', compact('mekaniks'));
    }

    public function create()
    {
        return view('owner.mekanik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Mekanik::create($request->all());
        return redirect()->route('owner.mekanik.index')
            ->with('success', 'Mekanik berhasil ditambahkan.');
    }

    public function edit(Mekanik $mekanik)
    {
        return view('owner.mekanik.edit', compact('mekanik'));
    }

    public function update(Request $request, Mekanik $mekanik)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $mekanik->update($request->all());
        return redirect()->route('owner.mekanik.index')
            ->with('success', 'Data mekanik berhasil diupdate.');
    }

    public function destroy(Mekanik $mekanik)
    {
        $mekanik->delete();
        return redirect()->route('owner.mekanik.index')
            ->with('success', 'Mekanik berhasil dihapus.');
    }

    public function show(Mekanik $mekanik)
    {
        return redirect()->route('owner.mekanik.index');
    }
}