<?php
// app/Http/Controllers/WargaController.php
namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    // public function index()
    // {
    //     $wargas = Warga::with(['rw', 'rt'])->get();
    //     return view('warga.index', compact('wargas'));
    // }

    // app/Http/Controllers/WargaController.php

    public function index(Request $request)
    {
        $search = $request->get('search');

        $wargas = Warga::with(['rw', 'rt'])
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        $rws = Rw::all();
        $rts = Rt::all();
        return view('warga.create', compact('rws', 'rts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:wargas|digits:16',
            'nama' => 'required|max:150',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required',
            'rw_id' => 'nullable|exists:rws,id',
            'rt_id' => 'nullable|exists:rts,id',
        ]);

        Warga::create($request->all());

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Warga $warga)
    {
        return view('warga.show', compact('warga'));
    }

    public function edit($id)
    {
        try {
            $warga = Warga::findOrFail($id);
            $rws = Rw::all();
            $rts = Rt::all();

            return view('warga.edit', compact('warga', 'rws', 'rts'));
        } catch (\Exception $e) {
            return redirect()->route('admin.warga.index')
                ->with('error', 'Data warga tidak ditemukan.');
        }
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:wargas,nik,' . $warga->id,
            'nama' => 'required|max:150',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required',
            'rw_id' => 'nullable|exists:rws,id',
            'rt_id' => 'nullable|exists:rts,id',
        ]);

        $warga->update($request->all());

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }
}
