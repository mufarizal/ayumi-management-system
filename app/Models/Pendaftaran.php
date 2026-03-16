<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'institusi',
        'program_id',
        'kelas_id',
        'status',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
