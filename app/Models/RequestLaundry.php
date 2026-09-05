<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestLaundry extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    public function detailLaundries()
    {
        return $this->hasMany(DetailLaundry::class, 'request_laundry_id');
    }
}
