<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encurtado extends Model {
    protected $fillable = ['url', 'codigo', 'status'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'encurtados';

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
}
