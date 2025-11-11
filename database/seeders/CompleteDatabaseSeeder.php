<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentTag;
use App\Models\Escola;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompleteDatabaseSeeder extends Seeder
{
    private $nomesMasculinos = [
        'João',
        'Pedro',
        'Lucas',
        'Gabriel',
        'Rafael',
        'Felipe',
        'Bruno',
        'Mateus',
        'Gustavo',
        'Carlos',
        'Daniel',
        'Ricardo',
        'Fernando',
        'André',
        'Paulo',
        'Marcos',
        'Diego',
        'Vitor',
        'Rodrigo',
        'Thiago',
        'Leonardo',
        'Henrique',
        'Alexandre',
        'Eduardo',
        'Marcelo',
        'Roberto',
        'Caio',
        'Murilo',
        'Igor',
        'Samuel'
    ];

    private $nomesFemininos = [
        'Ana',
        'Maria',
        'Júlia',
        'Isabella',
        'Sophia',
        'Laura',
        'Beatriz',
        'Valentina',
        'Gabriela',
        'Mariana',
        'Amanda',
        'Fernanda',
        'Juliana',
        'Camila',
        'Letícia',
        'Carla',
        'Bianca',
        'Bruna',
        'Carolina',
        'Larissa',
        'Natália',
        'Rafaela',
        'Alice',
        'Helena',
        'Luiza',
        'Cecília',
        'Eduarda',
        'Manuela',
        'Isabela',
        'Melissa'
    ];

    private $sobrenomes = [
        'Silva',
        'Santos',
        'Oliveira',
        'Souza',
        'Lima',
        'Costa',
        'Ferreira',
        'Rodrigues',
        'Alves',
        'Pereira',
        'Carvalho',
        'Ribeiro',
        'Martins',
        'Rocha',
        'Barbosa',
        'Araújo',
        'Fernandes',
        'Gomes',
        'Cardoso',
        'Correia',
        'Dias',
        'Mendes',
        'Nascimento',
        'Castro',
        'Azevedo',
        'Monteiro',
        'Lopes',
        'Ramos',
        'Freitas',
        'Soares'
    ];

    private $tagCounter = 1;
    private $alunoCounter = 1;

    public function run(): void
    {
        $this->command->info('🚀 Iniciando população completa do banco de dados...');

        // Definir contadores iniciais baseados nos dados existentes
        $maxAluno = Student::max('code');
        if ($maxAluno) {
            $num = (int) substr($maxAluno, -3);
            $this->alunoCounter = $num + 1;
        }

        $maxTag = StudentTag::max('epc');
        if ($maxTag) {
            $num = (int) substr($maxTag, -8);
            $this->tagCounter = $num + 1;
        }

        $this->command->info("📊 Iniciando contadores: Alunos={$this->alunoCounter}, Tags={$this->tagCounter}");

        // Criar dados para ESTRUTURA ANTIGA (Inglês)
        $this->command->info('📚 Criando dados para estrutura ANTIGA (inglês)...');
        $this->createSchoolsStructure();

        // Criar dados para ESTRUTURA NOVA (Português)
        $this->command->info('📚 Criando dados para estrutura NOVA (português)...');
        $this->createEscolasStructure();

        // Criar eventos de movimentação
        $this->command->info('📡 Criando eventos de movimentação...');
        $this->createMovementEvents();

        $this->command->info('✅ População completa finalizada!');
        $this->printSummary();
    }

    private function createSchoolsStructure()
    {
        // Obter próximo código de escola disponível
        $maxCode = School::max('code');
        $nextCode = 1;
        if ($maxCode) {
            $nextCode = ((int) substr($maxCode, 3)) + 1;
        }

        // Criar 3 escolas adicionais (ou verificar se já existem)
        $escolas = [
            ['name' => 'Colégio Estadual Paulo Freire', 'code' => sprintf('ESC%03d', $nextCode++), 'address' => 'Av. Brasil, 789 - Vila Nova'],
            ['name' => 'Escola Municipal Dom Pedro II', 'code' => sprintf('ESC%03d', $nextCode++), 'address' => 'Rua Sete de Setembro, 321 - Centro'],
            ['name' => 'Instituto Educacional São José', 'code' => sprintf('ESC%03d', $nextCode++), 'address' => 'Praça da República, 150 - Jardim Paulista'],
        ];

        foreach ($escolas as $escolaData) {
            $escola = School::firstOrCreate(
                ['code' => $escolaData['code']],
                $escolaData
            );

            // Criar 4 turmas por escola
            $anos = ['4º Ano', '5º Ano', '6º Ano', '7º Ano', '8º Ano', '9º Ano'];
            $turmas_letras = ['A', 'B', 'C'];

            $turmasSelecionadas = array_slice($anos, rand(0, 2), 4);

            foreach ($turmasSelecionadas as $ano) {
                $letra = $turmas_letras[array_rand($turmas_letras)];
                $turma = ClassRoom::create([
                    'school_id' => $escola->id,
                    'name' => "$ano $letra",
                    'year' => '2025',
                    'active' => true,
                ]);

                // Criar 25-30 alunos por turma
                $numAlunos = rand(25, 30);
                for ($i = 0; $i < $numAlunos; $i++) {
                    $genero = rand(0, 1);
                    $primeiroNome = $genero ? $this->nomesMasculinos[array_rand($this->nomesMasculinos)]
                        : $this->nomesFemininos[array_rand($this->nomesFemininos)];
                    $sobrenome1 = $this->sobrenomes[array_rand($this->sobrenomes)];
                    $sobrenome2 = $this->sobrenomes[array_rand($this->sobrenomes)];

                    $nomeCompleto = "$primeiroNome $sobrenome1 $sobrenome2";
                    $matricula = sprintf('ALU2025%03d', $this->alunoCounter++);

                    $aluno = Student::create([
                        'class_id' => $turma->id,
                        'name' => $nomeCompleto,
                        'code' => $matricula,
                        'birth_date' => Carbon::now()->subYears(rand(10, 15))->subDays(rand(1, 365)),
                        'active' => true,
                    ]);

                    // Criar tag RFID para o aluno
                    StudentTag::create([
                        'student_id' => $aluno->id,
                        'epc' => sprintf('E28011700000020%08d', $this->tagCounter++),
                        'assigned_at' => Carbon::now()->subDays(rand(1, 30)),
                        'active' => true,
                    ]);
                }
            }
        }
    }

    private function createEscolasStructure()
    {
        // Criar escolas na estrutura em português
        $escolasPt = [
            ['nome' => 'ESCOLA MUNICIPAL PROFESSOR ANTONIO CARLOS'],
            ['nome' => 'COLÉGIO TÉCNICO ESTADUAL GETÚLIO VARGAS'],
            ['nome' => 'CENTRO EDUCACIONAL NOSSA SENHORA APARECIDA'],
        ];

        foreach ($escolasPt as $escolaData) {
            $escola = Escola::create($escolaData);

            // Criar 3-4 turmas por escola
            $turmasNomes = [
                'FUNDAMENTAL I - 1º ANO',
                'FUNDAMENTAL I - 2º ANO',
                'FUNDAMENTAL I - 3º ANO',
                'FUNDAMENTAL II - 6º ANO',
                'FUNDAMENTAL II - 7º ANO',
                'ENSINO MÉDIO - 1º ANO',
                'ENSINO MÉDIO - 2º ANO',
            ];

            $turmasSelecionadas = array_slice($turmasNomes, rand(0, 3), 3);

            foreach ($turmasSelecionadas as $turmaNome) {
                $turma = Turma::create([
                    'escola_id' => $escola->id,
                    'nome' => $turmaNome,
                ]);

                // Criar 20-25 alunos por turma
                $numAlunos = rand(20, 25);
                for ($i = 0; $i < $numAlunos; $i++) {
                    $genero = rand(0, 1);
                    $primeiroNome = $genero ? $this->nomesMasculinos[array_rand($this->nomesMasculinos)]
                        : $this->nomesFemininos[array_rand($this->nomesFemininos)];
                    $sobrenome1 = $this->sobrenomes[array_rand($this->sobrenomes)];
                    $sobrenome2 = $this->sobrenomes[array_rand($this->sobrenomes)];

                    $nomeCompleto = strtoupper("$primeiroNome $sobrenome1 $sobrenome2");
                    $cpf = $this->gerarCPFFicticio();

                    $aluno = Aluno::create([
                        'turma_id' => $turma->id,
                        'nome' => $nomeCompleto,
                        'referencia' => $cpf,
                    ]);

                    // Criar tag RFID para o aluno
                    Tag::create([
                        'aluno_id' => $aluno->id,
                        'epc' => sprintf('E28011700000030%08d', $this->tagCounter++),
                        'ativo' => true,
                    ]);
                }
            }
        }
    }

    private function createMovementEvents()
    {
        // Criar eventos de movimentação para as últimas 7 dias
        $tags = StudentTag::with('student')->where('active', true)->get();
        $tagsNovas = Tag::with('aluno')->where('ativo', true)->get();

        $todasTags = $tags->merge($tagsNovas);

        // Selecionar aleatoriamente 30% das tags para ter eventos
        $tagsComEventos = $todasTags->random(min(150, $todasTags->count()));

        foreach ($tagsComEventos as $tag) {
            // Criar 1-5 eventos por tag nos últimos 7 dias
            $numEventos = rand(1, 5);

            for ($i = 0; $i < $numEventos; $i++) {
                $dataEvento = Carbon::now()->subDays(rand(0, 7))->subHours(rand(0, 23));

                DB::table('movement_events')->insert([
                    'epc' => $tag->epc,
                    'seen_at' => $dataEvento,
                    'source' => rand(0, 1) ? 'monitor' : 'itag_sync',
                    'antenna' => rand(1, 4),
                    'rssi' => rand(-80, -30),
                    'raw' => json_encode([
                        'epc' => $tag->epc,
                        'rssi' => rand(-80, -30),
                        'antenna' => rand(1, 4),
                        'timestamp' => $dataEvento->toISOString(),
                    ]),
                    'created_at' => $dataEvento,
                    'updated_at' => $dataEvento,
                ]);
            }
        }
    }

    private function gerarCPFFicticio()
    {
        // Gera CPF fictício no formato XXX.XXX.XXX-XX
        return sprintf(
            '%03d.%03d.%03d-%02d',
            rand(100, 999),
            rand(100, 999),
            rand(100, 999),
            rand(10, 99)
        );
    }

    private function printSummary()
    {
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('📊 RESUMO DOS DADOS CRIADOS');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('');

        $this->command->info('🏫 ESTRUTURA ANTIGA (Inglês - schools/students):');
        $this->command->info('   • Escolas: ' . School::count());
        $this->command->info('   • Turmas: ' . ClassRoom::count());
        $this->command->info('   • Alunos: ' . Student::count());
        $this->command->info('   • Tags RFID: ' . StudentTag::count());

        $this->command->info('');
        $this->command->info('🏫 ESTRUTURA NOVA (Português - escolas/alunos):');
        $this->command->info('   • Escolas: ' . Escola::count());
        $this->command->info('   • Turmas: ' . Turma::count());
        $this->command->info('   • Alunos: ' . Aluno::count());
        $this->command->info('   • Tags RFID: ' . Tag::count());

        $this->command->info('');
        $this->command->info('📡 EVENTOS:');
        $this->command->info('   • Movement Events: ' . DB::table('movement_events')->count());

        $this->command->info('');
        $this->command->info('📈 TOTAL GERAL:');
        $totalEscolas = School::count() + Escola::count();
        $totalTurmas = ClassRoom::count() + Turma::count();
        $totalAlunos = Student::count() + Aluno::count();
        $totalTags = StudentTag::count() + Tag::count();

        $this->command->info("   • Escolas: $totalEscolas");
        $this->command->info("   • Turmas: $totalTurmas");
        $this->command->info("   • Alunos: $totalAlunos");
        $this->command->info("   • Tags RFID: $totalTags");
        $this->command->info('   • Eventos: ' . DB::table('movement_events')->count());

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('✅ Banco de dados completamente populado!');
        $this->command->info('═══════════════════════════════════════════════');
    }
}
