<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    protected $fillable = [
        'trackable_type',
        'trackable_id',
        'user_id',
        'aksi',
        'keterangan',
        'foto_bukti'
    ];

    public function trackable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
