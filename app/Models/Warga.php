<?php
// app/Models/Warga.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'rw_id',
        'rt_id',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    // Relasi ke RW
    public function rw()
    {
        return $this->belongsTo(Rw::class, 'rw_id');
    }

    // Relasi ke RT
    public function rt()
    {
        return $this->belongsTo(Rt::class, 'rt_id');
    }

    // Relasi ke anggota lembaga
    public function anggotaLembaga()
    {
        return $this->hasMany(AnggotaLembaga::class, 'warga_id');
    }

    // // Relasi ke perangkat desa
    // public function perangkatDesa()
    // {
    //     return $this->hasMany(PerangkatDesa::class, 'warga_id');
    // }
}
