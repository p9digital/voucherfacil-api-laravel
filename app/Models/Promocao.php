<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promocao extends Model {
	protected $fillable = [
		'cliente_id',
		'titulo',
		'path',
		'resumo',
		'descricao',
		'regras',
		'desconto',
		'valor',
		'codigo',
		'dataInicio',
		'dataFim',
		'dataPublicacao',
		'pessoas',
		'periodo',
		'agendamento',
		'limite', // Limite total de vouchers permitidos
		'imagem',
		'metaDescription',
		'metaKeywords',
		'codigosAcompanhamento',
		'codigosConversao',
		'codigosAnalytics',
		'mostrar',
		'status',
		'limite_usuario', // Limite total de vouchers permitidos por usuário
		'limite_vouchers', // Limite total de vouchers permitidos
		'pesquisa',
		'pesquisas'
	];
	protected $guarded = ['id', 'created_at', 'update_at'];
	protected $table = 'promocoes';

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

	public function cliente() {
		return $this->belongsTo(Cliente::class);
	}

	public function interesses() {
		return $this->hasMany(Interesse::class, 'promocao_id', 'id');
	}

	public function promocaounidades() {
		return $this->hasMany(PromocaoUnidade::class, 'promocao_id', 'id')->where("status", "1")->orderBy("ordem", "ASC");
	}

	public function unidades() {
		return $this->belongsToMany(Unidade::class, 'promocoes_unidades', 'promocao_id', 'unidade_id')->wherePivot('status', '1');
	}

	public function leads() {
		return $this->hasMany(Lead::class);
	}

	public function fotos() {
		return $this->hasMany(Foto::class);
	}

	public function destaques() {
		return $this->hasMany(Destaque::class);
	}

	public function fotosAtivas() {
		return $this->hasMany(Foto::class)->where("status", "1");
	}

	public function cidades() {
		return $this->belongsToMany(Cidade::class)->wherePivot('status', '1')->withTimestamps();
	}

	/**
	 * Pega as cidades indiretas da promocao e faz uma ligacao direta
	 * na tabela cidade_promocao
	 */
	public function atualizaCidades() {
		$cidadesIndiretas = DB::table('promocoes')
			->select('cidades.id')
			->join('promocoes_unidades', 'promocoes.id', '=', 'promocoes_unidades.promocao_id')
			->join('unidades', 'promocoes_unidades.unidade_id', '=', 'unidades.id')
			->join('cidades', 'unidades.cidade_id', '=', 'cidades.codcidade')
			->where('promocoes.id', $this->id)
			->get();

		$cidadesIndiretasIds = collect([]);
		//por algum motivo ->toArray nao funciona, fazendo manualmente
		foreach ($cidadesIndiretas as $cidade) {
			if (!$cidadesIndiretasIds->has($cidade->id)) {
				$cidadesIndiretasIds->push($cidade->id);
			}
		}

		return $this->cidades()->sync($cidadesIndiretasIds);
	}
}
