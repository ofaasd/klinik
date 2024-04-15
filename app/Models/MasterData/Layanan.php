<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $fillable = [
        'nama', 'tarif'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('obat', 'like', '%'.$cari.'%');
    }
}
