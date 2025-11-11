<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentTag;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar Escolas
        $escola1 = School::create([
            'name' => 'Escola Municipal João da Silva',
            'code' => 'ESC001',
            'address' => 'Rua das Flores, 123 - Centro',
            'active' => true,
        ]);

        $escola2 = School::create([
            'name' => 'Colégio Estadual Maria Santos',
            'code' => 'ESC002',
            'address' => 'Av. Principal, 456 - Jardim Europa',
            'active' => true,
        ]);

        // Criar Turmas para Escola 1
        $turma1A = ClassRoom::create([
            'school_id' => $escola1->id,
            'name' => '5º Ano A',
            'year' => '2025',
            'active' => true,
        ]);

        $turma1B = ClassRoom::create([
            'school_id' => $escola1->id,
            'name' => '5º Ano B',
            'year' => '2025',
            'active' => true,
        ]);

        // Criar Turmas para Escola 2
        $turma2A = ClassRoom::create([
            'school_id' => $escola2->id,
            'name' => '6º Ano A',
            'year' => '2025',
            'active' => true,
        ]);

        // Criar Alunos para Turma 5º Ano A
        $alunosT1A = [
            ['name' => 'Ana Carolina Silva', 'code' => 'ALU2025001', 'birth_date' => '2015-03-15'],
            ['name' => 'Bruno Santos Oliveira', 'code' => 'ALU2025002', 'birth_date' => '2015-05-22'],
            ['name' => 'Carla Fernandes Costa', 'code' => 'ALU2025003', 'birth_date' => '2015-01-10'],
            ['name' => 'Daniel Rodrigues Lima', 'code' => 'ALU2025004', 'birth_date' => '2015-07-08'],
            ['name' => 'Eduarda Martins Souza', 'code' => 'ALU2025005', 'birth_date' => '2015-09-30'],
        ];

        foreach ($alunosT1A as $index => $alunoData) {
            $aluno = Student::create([
                'class_id' => $turma1A->id,
                'name' => $alunoData['name'],
                'code' => $alunoData['code'],
                'birth_date' => $alunoData['birth_date'],
                'active' => true,
            ]);

            // Atribuir tag RFID ao aluno
            StudentTag::create([
                'student_id' => $aluno->id,
                'epc' => sprintf('E28011700000020%08d', $index + 1),
                'assigned_at' => now(),
                'active' => true,
            ]);
        }

        // Criar Alunos para Turma 5º Ano B
        $alunosT1B = [
            ['name' => 'Felipe Alves Pereira', 'code' => 'ALU2025006', 'birth_date' => '2015-02-18'],
            ['name' => 'Gabriela Rocha Santos', 'code' => 'ALU2025007', 'birth_date' => '2015-06-25'],
            ['name' => 'Henrique Costa Silva', 'code' => 'ALU2025008', 'birth_date' => '2015-04-12'],
            ['name' => 'Isabela Lima Oliveira', 'code' => 'ALU2025009', 'birth_date' => '2015-08-07'],
            ['name' => 'João Pedro Souza', 'code' => 'ALU2025010', 'birth_date' => '2015-11-20'],
        ];

        foreach ($alunosT1B as $index => $alunoData) {
            $aluno = Student::create([
                'class_id' => $turma1B->id,
                'name' => $alunoData['name'],
                'code' => $alunoData['code'],
                'birth_date' => $alunoData['birth_date'],
                'active' => true,
            ]);

            // Atribuir tag RFID ao aluno
            StudentTag::create([
                'student_id' => $aluno->id,
                'epc' => sprintf('E28011700000020%08d', $index + 6),
                'assigned_at' => now(),
                'active' => true,
            ]);
        }

        // Criar Alunos para Turma 6º Ano A (Escola 2)
        $alunosT2A = [
            ['name' => 'Larissa Fernandes Martins', 'code' => 'ALU2025011', 'birth_date' => '2014-03-05'],
            ['name' => 'Mateus Silva Costa', 'code' => 'ALU2025012', 'birth_date' => '2014-09-15'],
            ['name' => 'Natália Santos Lima', 'code' => 'ALU2025013', 'birth_date' => '2014-01-28'],
            ['name' => 'Pedro Henrique Rocha', 'code' => 'ALU2025014', 'birth_date' => '2014-06-10'],
            ['name' => 'Rafaela Oliveira Souza', 'code' => 'ALU2025015', 'birth_date' => '2014-12-03'],
        ];

        foreach ($alunosT2A as $index => $alunoData) {
            $aluno = Student::create([
                'class_id' => $turma2A->id,
                'name' => $alunoData['name'],
                'code' => $alunoData['code'],
                'birth_date' => $alunoData['birth_date'],
                'active' => true,
            ]);

            // Atribuir tag RFID ao aluno
            StudentTag::create([
                'student_id' => $aluno->id,
                'epc' => sprintf('E28011700000020%08d', $index + 11),
                'assigned_at' => now(),
                'active' => true,
            ]);
        }

        $this->command->info('✅ Dados de teste criados com sucesso!');
        $this->command->info("📊 Criadas: {$escola1->name} e {$escola2->name}");
        $this->command->info("📚 Total de turmas: 3");
        $this->command->info("👥 Total de alunos: 15");
        $this->command->info("🏷️  Total de tags RFID: 15");
    }
}
