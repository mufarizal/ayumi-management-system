<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'nama_program',
        'harga',
        'deskripsi',
        'status'
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
