<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model {
  use Notifiable;

  protected $fillable = array('promocao_id', 'unidade_id', 'nome', 'email', 'telefone', 'form', 'voucher', 'data_voucher', 'horario_voucher', 'periodo_id', 'pessoas', 'utm_source', 'utm_medium', 'utm_term', 'utm_content', 'utm_campaign', 'gclid', 'origem', 'device', 'ip', 'validado', 'urlorigem', 'cpf');
  protected $guarded = ['id', 'created_at', 'update_at'];
  protected $table = 'leads';

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

  public function cidade() {
    return $this->belongsTo(Cidade::class, "cidade_id", "codcidade");
  }

  public function promocao() {
    return $this->belongsTo(Promocao::class, "promocao_id", "id");
  }

  public function unidade() {
    return $this->belongsTo(Unidade::class, "unidade_id", "id");
  }

  public function periodo() {
    return $this->belongsTo(Periodo::class, "periodo_id", "id");
  }

  public function pesquisa() {
    return $this->hasOne(Pesquisa::class, "lead_id", "id");
  }
}
