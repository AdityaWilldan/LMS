<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo uploadTugas()
 */
class Penilaian extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'id_nilai';
    protected $fillable = ['id_upload', 'nilai', 'feedback'];
    protected $dates = ['tanggal_nilai'];
    public $timestamps = false; 

    protected $casts = [
        'tanggal_nilai' => 'datetime',
    ];

    public function uploadTugas()
    {
        return $this->belongsTo(UploadTugas::class, 'id_upload');
    }
}