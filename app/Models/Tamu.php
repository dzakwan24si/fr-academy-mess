<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tamu extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'tamu_id');
    }

    public function latestReservasi()
    {
        return $this->hasOne(Reservasi::class, 'tamu_id')->latestOfMany('tanggal_checkin');
    }
}
