<?php
// app/Models/Rw.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_rw',
        'ketua_rw_warga_id',
    ];

    // Relasi ke ketua RW (warga)
    public function ketua()
    {
        return $this->belongsTo(Warga::class, 'ketua_rw_warga_id');
    }

    // Relasi ke RT
    public function rts()
    {
        return $this->hasMany(Rt::class, 'rw_id');
    }

    // Relasi ke warga
    public function wargas()
    {
        return $this->hasMany(Warga::class, 'rw_id');
    }
}
