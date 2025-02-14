<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model {
	protected $fillable = ['coduf', 'nome', 'uf', 'regiao'];
	protected $guarded = ['id'];
	protected $table = 'estados';

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
		return $this->hasMany(Unidade::class, 'estado_id', 'coduf');
	}

	// public function promocoes() {
	// 	return $this->hasManyDeepFromRelations($this->unidades(), (new Unidade)->promocoes());
	// }

	public function cidades() {
		return $this->hasMany(Cidade::class, 'uf', 'uf');
	}
}
