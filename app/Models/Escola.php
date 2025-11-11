<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $fillable = ['nome', 'code', 'logo', 'address', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'escola_id');
    }

    public function antennas()
    {
        return $this->hasMany(Antenna::class, 'escola_id');
    }
}
