<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo mahasiswa()
 */
class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = ['id_mahasiswa', 'pesan', 'status_baca'];
    protected $dates = ['tanggal_kirim'];
    public $timestamps = false;
    
    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}