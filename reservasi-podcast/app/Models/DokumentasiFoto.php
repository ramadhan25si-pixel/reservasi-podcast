<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumentasiFoto extends Model
{
    protected $table    = 'dokumentasi_foto';
    protected $fillable = ['reservasi_id', 'jenis_foto', 'file_foto', 'waktu_unggah', 'keterangan'];

    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class);
    }
}
