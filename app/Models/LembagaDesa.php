<?php
// app/Models/LembagaDesa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaDesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lembaga',
        'deskripsi',
        'kontak',
    ];

    // Relasi ke jabatan lembaga
    public function jabatans()
    {
        return $this->hasMany(JabatanLembaga::class, 'lembaga_id');
    }

    // Relasi ke anggota lembaga
    public function anggotas()
    {
        return $this->hasMany(AnggotaLembaga::class, 'lembaga_id');
    }
}
