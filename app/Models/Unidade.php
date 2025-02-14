<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model {
	protected $fillable = ['cliente_id', 'nome', 'path', 'estado_id', 'cidade_id', 'bairro', 'endereco', 'numero', 'complemento', 'telefone', 'telefone2', 'lat', 'lng', 'mapsId', 'status'];
	protected $guarded = ['id', 'created_at', 'update_at'];
	protected $table = 'unidades';

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

	public function promocoesunidades() {
		return $this->hasMany(PromocaoUnidade::class, 'unidade_id', 'id');
	}

	public function promocoes() {
		return $this->belongsToMany(Promocao::class, 'promocoes_unidades', 'unidade_id', 'promocao_id')->wherePivot('status', '1');
	}

	public function cliente() {
		return $this->belongsTo(Cliente::class);
	}

	public function estado() {
		return $this->belongsTo(Estado::class, 'estado_id', 'coduf');
	}

	public function cidade() {
		return $this->belongsTo(Cidade::class, 'cidade_id', 'codcidade');
	}

	public function leads() {
		return $this->hasMany(Lead::class, 'unidade_id', 'id');
	}

	public function diasfechados() {
		return $this->hasMany(Fechado::class, "unidade_id", "id");
	}
}
