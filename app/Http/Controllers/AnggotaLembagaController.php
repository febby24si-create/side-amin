<?php
// app/Http/Controllers/AnggotaLembagaController.php
namespace App\Http\Controllers;

use App\Models\AnggotaLembaga;
use App\Models\LembagaDesa;
use App\Models\Warga;
use App\Models\JabatanLembaga;
use Illuminate\Http\Request;

class AnggotaLembagaController extends Controller
{
    public function index($lembaga_id)
    {
        $lembaga = LembagaDesa::findOrFail($lembaga_id);
        $anggotas = AnggotaLembaga::with(['warga', 'jabatan'])
            ->where('lembaga_id', $lembaga_id)
            ->get();

        return view('lembaga.anggota_index', compact('lembaga', 'anggotas'));
    }

    public function create($lembaga_id)
    {
        $lembaga = LembagaDesa::findOrFail($lembaga_id);
        $wargas = Warga::all();
        $jabatans = JabatanLembaga::where('lembaga_id', $lembaga_id)->get();

        return view('lembaga.anggota_create', compact('lembaga', 'wargas', 'jabatans'));
    }

    public function store(Request $request, $lembaga_id)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id|unique:anggota_lembagas,warga_id,NULL,id,lembaga_id,' . $lembaga_id,
            'jabatan_id' => 'required|exists:jabatan_lembagas,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after:tgl_mulai',
        ]);

        AnggotaLembaga::create([
            'lembaga_id' => $lembaga_id,
            'warga_id' => $request->warga_id,
            'jabatan_id' => $request->jabatan_id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
        ]);

        return redirect()->route('admin.lembaga.anggota.index', $lembaga_id)
            ->with('success', 'Anggota lembaga berhasil ditambahkan.');
    }

    public function edit($lembaga_id, $id)
    {
        $lembaga = LembagaDesa::findOrFail($lembaga_id);
        $anggota = AnggotaLembaga::findOrFail($id);
        $wargas = Warga::all();
        $jabatans = JabatanLembaga::where('lembaga_id', $lembaga_id)->get();

        return view('lembaga.anggota_edit', compact('lembaga', 'anggota', 'wargas', 'jabatans'));
    }

    public function update(Request $request, $lembaga_id, $id)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id|unique:anggota_lembagas,warga_id,' . $id . ',id,lembaga_id,' . $lembaga_id,
            'jabatan_id' => 'required|exists:jabatan_lembagas,id',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'nullable|date|after:tgl_mulai',
        ]);

        $anggota = AnggotaLembaga::findOrFail($id);
        $anggota->update($request->all());

        return redirect()->route('admin.lembaga.anggota.index', $lembaga_id)
            ->with('success', 'Anggota lembaga berhasil diperbarui.');
    }

    public function destroy($lembaga_id, $id)
    {
        $anggota = AnggotaLembaga::findOrFail($id);
        $anggota->delete();

        return redirect()->route('admin.lembaga.anggota.index', $lembaga_id)
            ->with('success', 'Anggota lembaga berhasil dihapus.');
    }
}
