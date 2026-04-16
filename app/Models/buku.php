<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'foto'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
