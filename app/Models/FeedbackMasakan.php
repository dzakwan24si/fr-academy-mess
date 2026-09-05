<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackMasakan extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function tamu()
    {
        return $this->belongsTo(Tamu::class);
    }

    public function rencanaMenuHarian()
    {
        return $this->belongsTo(RencanaMenuHarian::class);
    }
}
