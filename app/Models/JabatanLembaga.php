<?php
// app/Models/JabatanLembaga.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanLembaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'lembaga_id',
        'nama_jabatan',
        'level',
    ];

    // Relasi ke lembaga
    public function lembaga()
    {
        return $this->belongsTo(LembagaDesa::class, 'lembaga_id');
    }

    // Relasi ke anggota lembaga
    public function anggotas()
    {
        return $this->hasMany(AnggotaLembaga::class, 'jabatan_id');
    }
}
