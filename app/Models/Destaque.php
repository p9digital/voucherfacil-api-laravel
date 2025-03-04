<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destaque extends Model {
  protected $fillable = [
    'cidade_id',
    'visivel_somente_cidade',
    'titulo',
    'subtitulo',
    'descricaco',
    'link',
    'foto_original',
    'foto_desk_xxl',
    'foto_desk_xl',
    'foto_desk',
    'foto_mob',
    'foto_mob_xs',
    'foto_mob_xxs',
    'status'
  ];

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

  public function scopeAtivos($query) {
    return $query->where('status', 1);
  }

  public function cidade() {
    return $this->belongsTo(Cidade::class, 'cidade_id', 'codcidade');
  }

  public function cliente() {
    return $this->belongsTo(Cliente::class);
  }

  public function promocao() {
    return $this->belongsTo(Promocao::class);
  }
}
