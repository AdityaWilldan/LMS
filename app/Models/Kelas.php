<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo mataKuliah()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany mahasiswa()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany tugas()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany jadwal()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany absensi()
 */
class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = ['nama_kelas', 'semester', 'tahun_ajaran', 'id_matkul'];
    public $timestamps = false;

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_matkul');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'mahasiswa_kelas', 'id_kelas', 'id_mahasiswa');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'id_kelas');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_kelas');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_kelas');
    }
}