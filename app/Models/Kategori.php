<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'id_kategori', 'id_kategori');
    }
}