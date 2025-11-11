<?php

namespace App\Services;

use App\Models\Escola;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Tag;
use App\Support\TextNormalizer;
use Illuminate\Support\Facades\DB;

class AutoCadastroService
{
    /**
     * Garante a existência de Escola, Turma, Aluno e Tag
     * a partir de um payload mínimo vindo do monitor/inventário.
     *
     * Campos esperados quando disponíveis:
     *  - epc (obrigatório)
     *  - nome (aluno)
     *  - referencia (CPF/código)
     *  - extra1 (escola)
     *  - extra2 (turma)
     */
    public function ensureHierarchy(array $payload): Tag
    {
        $epc = $payload['epc'] ?? $payload['EPC'] ?? null;
        if (!$epc) throw new \InvalidArgumentException('EPC ausente no payload');

        return DB::transaction(function () use ($epc, $payload) {

            // Normalizações
            $nomeEscola = TextNormalizer::up($payload['extra1'] ?? 'ESCOLA DESCONHECIDA');
            $nomeTurma  = TextNormalizer::up($payload['extra2'] ?? 'SEM TURMA');
            $nomeAluno  = TextNormalizer::up($payload['nome']   ?? 'ALUNO NÃO IDENTIFICADO');
            $refAluno   = trim((string)($payload['referencia'] ?? '')) ?: null;

            // Escola
            $escola = Escola::firstOrCreate(['nome' => $nomeEscola]);

            // Turma
            $turma = Turma::firstOrCreate([
                'escola_id' => $escola->id,
                'nome'      => $nomeTurma,
            ]);

            // Aluno (preferir referencia quando existir)
            if ($refAluno) {
                $aluno = Aluno::firstOrCreate(
                    ['referencia' => $refAluno, 'turma_id' => $turma->id],
                    ['nome' => $nomeAluno]
                );
            } else {
                $aluno = Aluno::firstOrCreate(
                    ['turma_id' => $turma->id, 'nome' => $nomeAluno],
                    ['referencia' => null]
                );
            }

            // Tag
            $tag = Tag::firstOrCreate(
                ['epc' => $epc],
                ['aluno_id' => $aluno->id, 'ativo' => true]
            );

            // Se a tag já existia mas apontava para outro aluno (uniforme trocado), realoque opcionalmente:
            if ($tag->aluno_id !== $aluno->id) {
                $tag->aluno_id = $aluno->id;
                $tag->save();
            }

            return $tag;
        });
    }
}

