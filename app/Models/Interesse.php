<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interesse extends Model {
  protected $fillable = [
    'nome',
    'email',
    'celular',
    'uf',
    'cidade',
    'promocao_id',
    'utm_source',
    'utm_medium',
    'utm_term',
    'utm_campaign',
    'utm_content',
    'gclid',
    'origem',
    'device',
    'referrer',
    'ip'
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

  public function promocao() {
    return $this->belongsTo(Promocao::class);
  }
}
