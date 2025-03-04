<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model {
  protected $fillable = ['codcidade', 'nome', 'uf', 'prioridade', 'path'];
  protected $guarded = ['id'];
  protected $table = 'cidades';
  public $timestamps = false;

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

  public function unidades() {
    return $this->hasMany(Unidade::class, 'cidade_id', 'codcidade');
  }

  public function destaques() {
    return $this->hasMany(Destaque::class, 'cidade_id', 'codcidade');
  }

  public function promocoes() {
    return $this->belongsToMany(Promocao::class)->wherePivot('status', '1')->withTimestamps();
  }

  public function estado() {
    return $this->belongsTo(Estado::class, 'uf', 'uf');
  }
}
