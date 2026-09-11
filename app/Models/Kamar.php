<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_kamar',
        'lokasi',
        'tipe_kamar',
        'kapasitas',
        'status',
    ];

    public function asets()
    {
        return $this->belongsToMany(AsetMess::class, 'aset_kamar', 'kamar_id', 'aset_mess_id')
                    ->withPivot('id', 'jumlah', 'kondisi', 'keterangan', 'tanggal_maintenance', 'catatan_perbaikan', 'foto_perbaikan')
                    ->withTimestamps();
    }

    public function riwayatAktivitas()
    {
        return $this->morphMany(RiwayatAktivitas::class, 'trackable')->latest();
    }
}
