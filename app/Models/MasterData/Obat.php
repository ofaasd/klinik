<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';
    protected $fillable = [
        'kode', 'obat','satuan','harga_jual'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('obat', 'like', '%'.$cari.'%');
    }
}
