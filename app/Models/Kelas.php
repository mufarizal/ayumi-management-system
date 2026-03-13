<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'program_id',
        'nama_kelas',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
