<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservasi extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function tamu()
    {
        return $this->belongsTo(Tamu::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
