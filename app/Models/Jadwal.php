<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo kelas()
 */
class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = ['id_kelas', 'hari', 'jam_mulai', 'jam_selesai', 'ruangan'];
    public $timestamps = false;

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}