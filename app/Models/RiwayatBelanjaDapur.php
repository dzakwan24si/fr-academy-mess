<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatBelanjaDapur extends Model
{
    protected $guarded = [];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
