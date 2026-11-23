<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TataTertib extends Model
{
    protected $table    = 'tata_tertib';
    protected $fillable = ['judul_aturan', 'isi_aturan', 'status_aktif'];
    protected $casts    = ['status_aktif' => 'boolean'];
}
