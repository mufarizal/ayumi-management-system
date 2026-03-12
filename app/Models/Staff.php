<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'jabatan',
        'departemen',
        'tanggal_bergabung',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
