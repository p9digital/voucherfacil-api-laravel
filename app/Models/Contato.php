<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model {
    protected $fillable = ['nome', 'email', 'telefone', 'mensagem', 'assunto', 'empresa', 'unidade_id'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'contatos';

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
