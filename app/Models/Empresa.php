<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {
  protected $fillable = ['nome_completo', 'nome_empresa', 'email', 'whatsapp', 'uf', 'cidade', 'segmento_empresa', 'atendimentos', 'ticket_medio'];
  protected $guarded = ['id', 'created_at', 'update_at'];
  protected $table = 'empresas';

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
