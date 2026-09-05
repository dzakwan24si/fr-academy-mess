<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function bahanBakus()
    {
        return $this->belongsToMany(BahanBaku::class, 'resep_bahan', 'menu_id', 'bahan_baku_id')
                    ->withPivot('jumlah_dibutuhkan');
    }
}
