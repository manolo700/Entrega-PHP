<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'role_id',
        'active',
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
            'active' => 'boolean',
        ];
    }

    /**
     * Relación con el Rol del usuario.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Verifica si el usuario tiene un rol determinado (por nombre 'admin', 'auditor', etc.).
     */
    public function hasRole(string|array $roles): bool
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->name, $roles, true);
        }

        return $this->role->name === $roles;
    }

    /**
     * Verifica si el usuario es Administrador.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Verifica si el usuario está activo.
     */
    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    /**
     * Verifica si el usuario cuenta con un permiso específico.
     * Los administradores tienen todos los permisos habilitados por defecto.
     */
    public function hasPermission(string $permissionName): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermission($permissionName);
    }
}
