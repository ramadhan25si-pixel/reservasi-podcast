<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fasilitas extends Model
{
    protected $table    = 'fasilitas';
    protected $fillable = ['ruang_id', 'nama_fasilitas', 'jumlah', 'kondisi'];

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(RuangPodcast::class, 'ruang_id');
    }

    public function reservasi(): BelongsToMany
    {
        return $this->belongsToMany(Reservasi::class, 'detail_reservasi_fasilitas', 'fasilitas_id', 'reservasi_id')
            ->withPivot('jumlah_digunakan');
    }
}
