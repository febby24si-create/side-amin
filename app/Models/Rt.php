<?php
// app/Models/Rt.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;

    protected $fillable = [
        'rw_id',
        'nomor_rt',
        'ketua_rt_warga_id',
    ];

    // Relasi ke RW
    public function rw()
    {
        return $this->belongsTo(Rw::class, 'rw_id');
    }

    // Relasi ke ketua RT (warga)
    public function ketua()
    {
        return $this->belongsTo(Warga::class, 'ketua_rt_warga_id');
    }

    // Relasi ke warga
    public function wargas()
    {
        return $this->hasMany(Warga::class, 'rt_id');
    }
}
