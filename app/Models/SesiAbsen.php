<?php
// app/Models/SesiAbsen.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiAbsen extends Model
{
    protected $table = 'sesi_absen';
    protected $primaryKey = 'id_sesi';
    protected $fillable = ['id_kelas', 'tanggal', 'aktif'];
    protected $casts = [
        'tanggal' => 'date',
        'aktif' => 'boolean',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}