<?php

namespace App\Services;

use App\Models\Antenna;
use App\Models\Aluno;

class AntennaResolver
{
    /**
     * Resolve (ou cria) a Antenna para a escola do aluno informado,
     * com base no "codigo" de antena recebido no evento.
     *
     * @param  int|null    $alunoId   ID do aluno (para chegar na escola via turma)
     * @param  string|null $codigo    Valor recebido no evento (ex.: "1", "2")
     * @return \App\Models\Antenna|null
     */
    public function resolveForAluno(?int $alunoId, ?string $codigo): ?Antenna
    {
        if (!$alunoId || $codigo === null || $codigo === '') {
            return null;
        }

        $aluno = Aluno::with('turma.escola')->find($alunoId);
        if (!$aluno || !$aluno->turma || !$aluno->turma->escola) {
            return null;
        }

        $escolaId = $aluno->turma->escola->id;

        // normaliza o código como string trimada
        $codigo = trim((string)$codigo);

        return Antenna::firstOrCreate(
            ['escola_id' => $escolaId, 'codigo' => $codigo],
            ['descricao' => 'Antena ' . $codigo, 'ativo' => true]
        );
    }
}

