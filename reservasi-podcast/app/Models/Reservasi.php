<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    // Status yang mengunci slot (dipakai kalender dan validasi bentrok)
    public const STATUS_MENGUNCI = ['pending', 'disetujui', 'selesai'];

    protected $fillable = [
        'user_id', 'ruang_id', 'tanggal_reservasi', 'waktu_mulai',
        'waktu_selesai', 'keperluan', 'status_reservasi', 'tanggal_pengajuan',
    ];

    public const JAM_OPERASIONAL = [
    '08:00', '09:00', '10:00', '11:00', '12:00',
    '13:00', '14:00', '15:00', '16:00', '17:00',
    ];

    public const MAKS_DURASI_JAM = 3;

    protected $casts = [
        'tanggal_reservasi' => 'date',
        'tanggal_pengajuan' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(RuangPodcast::class, 'ruang_id');
    }

    public function fasilitas(): BelongsToMany
    {
        return $this->belongsToMany(Fasilitas::class, 'detail_reservasi_fasilitas', 'reservasi_id', 'fasilitas_id')
            ->withPivot('jumlah_digunakan')
            ->withTimestamps();
    }

    public function dokumentasi(): HasMany
    {
        return $this->hasMany(DokumentasiFoto::class);
    }

    public function persetujuan(): HasMany
    {
        return $this->hasMany(PersetujuanTataTertib::class);
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    // Kode seperti di wireframe: RES-202611-004
    public function getKodeAttribute(): string
    {
        return sprintf('RES-%s-%03d', $this->tanggal_reservasi->format('Ym'), $this->id);
    }

    // Dipakai nanti di validasi form: Reservasi::bentrok(...)->exists()
    public function scopeBentrok($query, $ruangId, $tanggal, $mulai, $selesai)
    {
    return $query->where('ruang_id', $ruangId)
        ->whereDate('tanggal_reservasi', $tanggal)
        ->whereIn('status_reservasi', self::STATUS_MENGUNCI)
        ->whereRaw('substr(waktu_mulai, 1, 5) < ?', [$selesai])
        ->whereRaw('substr(waktu_selesai, 1, 5) > ?', [$mulai]);
    }
}
