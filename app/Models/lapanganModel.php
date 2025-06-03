<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lapanganModel extends Model
{
    protected $table = 'lapangan';

    protected $fillable = [
        'rumah',
        'deskripsi',
        'luas_tanah',
        'luas_bangunan',
        'jumlah_kamar',
        'jumlah_kamar_mandi',
        'harga',
        'status',
        'type',
        'gambar',
        'garasi',
    ];
}
