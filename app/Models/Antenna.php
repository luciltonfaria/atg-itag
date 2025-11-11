<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antenna extends Model
{
    protected $fillable = ['escola_id', 'codigo', 'descricao', 'ativo'];

    public function escola()
    {
        return $this->belongsTo(\App\Models\Escola::class);
    }
}

