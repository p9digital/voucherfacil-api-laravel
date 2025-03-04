<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model {
  protected $fillable = ['promocaounidade_id', 'nome', 'periodo', 'ordem', 'status'];
  protected $guarded = ['id', 'created_at', 'update_at'];
  protected $table = 'periodos';

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
    return $this->belongsTo(Unidade::class, "unidade_id", "id");
  }
}
