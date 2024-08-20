<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membaca extends Model
{
    use HasFactory;

    protected $table = 'membaca';

    protected $fillable = [
        'pembaca_id',
        'buku_id',
        'tgl_baca',
        'durasi'
        
    ];
}
