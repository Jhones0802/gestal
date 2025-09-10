<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'role',
        'cedula',
        'cargo',
        'estado'
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

    // Método para verificar si es administrador
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Método para verificar si es analista de RRHH
    public function isAnalista(): bool
    {
        return $this->role === 'analista_rh';
    }

    // Método para verificar si es empleado
    public function isEmpleado(): bool
    {
        return $this->role === 'empleado';
    }
}