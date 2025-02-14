<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model {
    protected $fillable = ['promocao_id', 'arquivo', 'ordem'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'fotos';

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

    public function promocao() {
        return $this->belongsTo(Promocao::class);
    }
}
