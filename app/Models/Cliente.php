<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
	protected $fillable = ['razaoSocial', 'nomeFantasia', 'path', 'telefone', 'bgcolor', 'bgform', 'corfonte'];
	protected $guarded = ['id', 'created_at', 'update_at'];
	protected $table = 'clientes';

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

	public function promocoes() {
		return $this->hasMany(Promocao::class);
	}

	public function destaques() {
		return $this->hasMany(Destaque::class);
	}
}
