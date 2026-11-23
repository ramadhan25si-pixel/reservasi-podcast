<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanTataTertib extends Model
{
    protected $table    = 'persetujuan_tata_tertib';
    protected $fillable = ['user_id', 'tata_tertib_id', 'reservasi_id', 'tanggal_persetujuan', 'status_persetujuan'];
}
