<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $connection = 'pgsql_berita';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'id_kategori',
        'id_admin',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}