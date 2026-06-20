<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo tugas()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo mahasiswa()
 * @method \Illuminate\Database\Eloquent\Relations\HasOne penilaian()
 */
class UploadTugas extends Model
{
    protected $table = 'upload_tugas';
    protected $primaryKey = 'id_upload';
    protected $fillable = ['id_tugas', 'id_mahasiswa', 'nama_file', 'status'];
    public $timestamps = false;

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'id_upload');
    }
}