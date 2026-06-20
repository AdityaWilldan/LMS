<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo dosen()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany kelas()
 */
class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'id_matkul';
    protected $fillable = ['kode_matkul', 'nama_matkul', 'sks', 'id_dosen'];
    public $timestamps = false;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_matkul');
    }
}