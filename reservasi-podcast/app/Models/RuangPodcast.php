<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RuangPodcast extends Model
{
    protected $table = 'ruang_podcast';

    protected $fillable = ['nama_ruang', 'lokasi', 'kapasitas', 'deskripsi', 'status_ruang'];

    public function fasilitas(): HasMany
    {
        return $this->hasMany(Fasilitas::class, 'ruang_id');
    }

    public function reservasi(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'ruang_id');
    }
}
