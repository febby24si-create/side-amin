<?php
// app/Http/Controllers/LembagaDesaController.php
namespace App\Http\Controllers;

use App\Models\LembagaDesa;
use Illuminate\Http\Request;

class LembagaDesaController extends Controller
{
    public function index()
    {
        $lembagas = LembagaDesa::withCount(['anggotas', 'jabatans'])->with('anggotas', 'jabatans')->get();
        return view('lembaga.index', compact('lembagas'));
    }

    public function create()
    {
        return view('lembaga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|max:100',
            'deskripsi' => 'required',
            'kontak' => 'nullable|max:20',
        ]);

        LembagaDesa::create($request->all());

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga desa berhasil ditambahkan.');
    }

    public function show(LembagaDesa $lembaga)
    {
        $lembaga->load(['jabatans', 'anggotas.warga', 'anggotas.jabatan']);
        return view('lembaga.show', compact('lembaga'));
    }

    public function edit(LembagaDesa $lembaga)
    {
        return view('lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, LembagaDesa $lembaga)
    {
        $request->validate([
            'nama_lembaga' => 'required|max:100',
            'deskripsi' => 'required',
            'kontak' => 'nullable|max:20',
        ]);

        $lembaga->update($request->all());

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga desa berhasil diperbarui.');
    }

    public function destroy(LembagaDesa $lembaga)
    {
        $lembaga->delete();

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Lembaga desa berhasil dihapus.');
    }
}
