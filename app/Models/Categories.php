<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kategori';
    protected $table = 'categories';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];
}