<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['epc', 'aluno_id', 'ativo'];
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}

