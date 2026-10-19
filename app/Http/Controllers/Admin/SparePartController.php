<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index(Request $request)
    {
        $query = SparePart::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('kode', 'like', "%$search%")
                    ->orWhere('kategori', 'like', "%$search%");
            });
        }

        if ($request->filled('stok')) {
            if ($request->stok === 'menipis') {
                $query->whereColumn('stok', '<=', 'stok_minimum');
            } elseif ($request->stok === 'aman') {
                $query->whereColumn('stok', '>', 'stok_minimum');
            }
        }

        $spareParts = $query->latest()->paginate(10)->withQueryString();
        return view('admin.spare-part.index', compact('spareParts'));
    }
    public function create()
    {
        return view('admin.spare-part.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'kode' => 'required|string|unique:spare_parts,kode',
            'kategori' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        SparePart::create($request->all());
        return redirect()->route('admin.spare-part.index')
            ->with('success', 'Spare part berhasil ditambahkan.');
    }

    public function edit(SparePart $sparePart)
    {
        return view('admin.spare-part.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'kode' => 'required|string|unique:spare_parts,kode,' . $sparePart->id,
            'kategori' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $sparePart->update($request->all());
        return redirect()->route('admin.spare-part.index')
            ->with('success', 'Spare part berhasil diupdate.');
    }

    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();
        return redirect()->route('admin.spare-part.index')
            ->with('success', 'Spare part berhasil dihapus.');
    }

    public function show(SparePart $sparePart)
    {
        return redirect()->route('admin.spare-part.index');
    }
}