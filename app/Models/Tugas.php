<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    protected $fillable = ['judul_tugas', 'deskripsi', 'file_materi', 'deadline', 'id_kelas'];
    public $timestamps = false;

    protected $casts = [
        'deadline' => 'datetime',
        'tanggal_buat' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function uploadTugas()
    {
        return $this->hasMany(UploadTugas::class, 'id_tugas');
    }

    // Accessor untuk URL file
    public function getFileMateriUrlAttribute()
    {
        if ($this->file_materi) {
            return Storage::url($this->file_materi);
        }
        return null;
    }

    // Hapus file saat tugas dihapus
    protected static function booted()
    {
        static::deleting(function ($tugas) {
            if ($tugas->file_materi) {
                Storage::delete($tugas->file_materi);
            }
        });
    }
}