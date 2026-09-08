<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveiKepuasanKamar extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}
