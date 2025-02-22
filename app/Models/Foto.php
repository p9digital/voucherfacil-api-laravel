<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model {
    protected $fillable = ['promocao_id', 'arquivo', 'ordem', 'foto_mob_xs', 'foto_mob', 'foto_card', 'foto_desk', 'foto_desk_xl'];
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
