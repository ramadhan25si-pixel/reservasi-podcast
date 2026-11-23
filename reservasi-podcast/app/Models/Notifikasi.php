<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table    = 'notifikasi';
    protected $fillable = ['reservasi_id', 'user_id', 'isi_notifikasi', 'jenis_notifikasi', 'waktu_kirim', 'status_baca'];
    protected $casts = ['status_baca' => 'boolean', 'waktu_kirim' => 'datetime'];

    public function reservasi(): BelongsTo { return $this->belongsTo(Reservasi::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
