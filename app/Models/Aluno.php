<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['turma_id', 'nome', 'referencia'];
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}

