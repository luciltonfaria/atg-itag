<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Escola;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário para cada escola
        $escolas = Escola::all();

        foreach ($escolas as $escola) {
            // Criar email baseado no nome da escola
            $email = strtolower(str_replace([' ', '-'], '', $escola->nome));
            $email = substr($email, 0, 20) . '@itag.com';

            User::create([
                'name' => 'Admin ' . $escola->nome,
                'email' => $email,
                'password' => Hash::make('senha123'),
                'escola_id' => $escola->id,
            ]);
        }

        // Usuário master sem escola (admin geral) - opcional
        User::create([
            'name' => 'Administrador Geral',
            'email' => 'admin@itag.com',
            'password' => Hash::make('admin123'),
            'escola_id' => null,
        ]);

        $this->command->info('✅ Usuários criados com sucesso!');
        $this->command->info('📧 Escolas: ' . $escolas->count() . ' usuários');
        $this->command->info('🔑 Senha padrão: senha123');
    }
}
