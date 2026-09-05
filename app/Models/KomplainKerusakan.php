<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KomplainKerusakan extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }
}
