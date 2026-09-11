<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsetMess extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kamars()
    {
        return $this->belongsToMany(Kamar::class, 'aset_kamar', 'aset_mess_id', 'kamar_id')
                    ->withPivot('id', 'jumlah', 'kondisi', 'keterangan', 'tanggal_maintenance', 'catatan_perbaikan', 'foto_perbaikan')
                    ->withTimestamps();
    }

    public function riwayatAktivitas()
    {
        return $this->morphMany(RiwayatAktivitas::class, 'trackable')->latest();
    }
}
