<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method \Illuminate\Database\Eloquent\Relations\HasMany mataKuliah()
 */
class Dosen extends Authenticatable
{
    use Notifiable;
    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';
    protected $fillable = ['nama_dosen', 'email', 'username', 'password'];
    protected $hidden = ['password'];
    public $timestamps = false;

    public function mataKuliah()
    {
        return $this->hasMany(MataKuliah::class, 'id_dosen');
    }
}