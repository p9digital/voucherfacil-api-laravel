<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desabilitado extends Model {
    protected $fillable = ['promocaounidade_id', 'dia'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'desabilitados';

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

    public function promocaounidade() {
        return $this->hasOne(PromocaoUnidade::class, 'id', 'promocaounidade_id');
    }
}
