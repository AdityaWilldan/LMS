<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany kelas()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany uploadTugas()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany absensi()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany notifikasi()
 */
class Mahasiswa extends Authenticatable
{
    use Notifiable;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = ['nim', 'nama_mahasiswa', 'email', 'username', 'password', 'status_aktif'];
    protected $hidden = ['password'];
    public $timestamps = false;

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'mahasiswa_kelas', 'id_mahasiswa', 'id_kelas');
    }

    public function uploadTugas()
    {
        return $this->hasMany(UploadTugas::class, 'id_mahasiswa');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_mahasiswa');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_mahasiswa');
    }
}