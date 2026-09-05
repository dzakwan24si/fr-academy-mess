<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tamu extends Authenticatable
{
    use SoftDeletes;

    protected $guarded = [];
}
