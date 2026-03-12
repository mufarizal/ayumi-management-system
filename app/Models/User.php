<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'created_by',
        'must_change_password',
        'default_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function hasAnyRole(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function getActiveRole()
    {
        return session('active_role') ?? $this->default_role ?? $this->roles()->first()?->name ?? 'siswa';
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function pengajar()
    {
        return $this->hasOne(Pengajar::class);
    }
}
