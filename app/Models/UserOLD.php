<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Tymon\JWTAuth\Contracts\JWTSubject;

// class UserOLD extends Authenticatable implements JWTSubject {
class UserOLD extends Authenticatable {
    use Notifiable;
    protected $fillable = ['cliente_id', 'unidade_id', 'name', 'email', 'password', 'tipo', 'status'];
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     * 
     * Documentação aqui
     * https://laravel.com/docs/11.x/eloquent-mutators
     * 
     */
    protected function casts(): array {
        return [
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function cliente() {
        return $this->hasOne("App\Cliente", "id", "cliente_id");
    }

    public function unidade() {
        return $this->hasOne("App\Unidade", "id", "unidade_id");
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
