<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailLaundry extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function requestLaundry()
    {
        return $this->belongsTo(RequestLaundry::class);
    }
}
