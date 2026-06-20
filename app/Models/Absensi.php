<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo mahasiswa()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo kelas()
 */
class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    protected $fillable = ['id_mahasiswa', 'id_kelas', 'tanggal', 'status'];
    protected $dates = ['tanggal'];
    public $timestamps = false;

    protected $casts = [
        'tanggal' => 'date', // date, bukan datetime
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}