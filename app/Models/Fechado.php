<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fechado extends Model {
  protected $fillable = ['unidade_id', 'diasemana', 'periodo'];
  protected $guarded = ['id', 'created_at', 'update_at'];
  protected $table = 'fechados';

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

  public function unidade() {
    return $this->hasOne(Unidade::class, 'id', 'unidade_id');
  }
}
