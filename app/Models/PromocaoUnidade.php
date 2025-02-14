<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromocaoUnidade extends Model {
	protected $fillable = ['promocao_id', 'unidade_id'];
	protected $guarded = ['id', 'created_at', 'update_at'];
	protected $table = 'promocoes_unidades';

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

	public function unidade() {
		return $this->belongsTo(Unidade::class, 'unidade_id', 'id');
	}

	public function periodos() {
		return $this->hasMany(Periodo::class, 'promocaounidade_id', 'id');
	}

	public function periodosAtivos() {
		return $this->hasMany(Periodo::class, 'promocaounidade_id', 'id')->where("status", "1")->orderBy("ordem", "ASC");
	}

	public function desabilitados() {
		return $this->hasMany(Desabilitado::class, 'promocaounidade_id', 'id');
	}
}
