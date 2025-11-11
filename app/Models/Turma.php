<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = ['escola_id', 'nome'];
    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }
    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}

