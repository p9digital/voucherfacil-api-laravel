<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {
  protected $fillable = ['user_id', 'log'];
  protected $guarded = ['id', 'created_at', 'update_at'];
  protected $table = 'logs';

  public function usuario() {
    return $this->belongsTo(User::class, "id", "user_id");
  }

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
