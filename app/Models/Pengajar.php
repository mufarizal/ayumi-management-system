<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    protected $table = 'pengajar';
    protected $fillable = [
        'user_id',
        'no_telp',
        'no_rekening',
        'nama_bank',
        'alamat',
        'level_bahasa',
        'sertifikat',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
