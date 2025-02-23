<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Adicionando o campo role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Métodos auxiliares para verificar o tipo de usuário
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isNormal(): bool
    {
        return $this->role === 'normal';
    }

    public function hasRole($roles): bool
{
    if (is_array($roles)) {
        return in_array($this->role, $roles);
    }
    return $this->role === $roles;
}
}
