<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesquisa extends Model {
    protected $fillable = ['promocao_id', 'unidade_id', 'lead_id', 'pesquisas', 'respostas'];
    protected $guarded = ['id', 'created_at', 'update_at'];

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
        return $this->belongsTo(Promocao::class, "promocao_id", "id");
    }

    public function unidade() {
        return $this->belongsTo(Unidade::class, "unidade_id", "id");
    }

    public function lead() {
        return $this->belongsTo(Lead::class, "lead_id", "id");
    }
}
