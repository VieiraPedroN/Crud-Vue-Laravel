<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = ['nome', 'data_nascimento'];

    public function emails() {
        return $this->hasMany(Email::class, 'usuario_id');
    }

    public function telefones() {
        return $this->hasMany(Telefone::class, 'usuario_id');
    }
}
