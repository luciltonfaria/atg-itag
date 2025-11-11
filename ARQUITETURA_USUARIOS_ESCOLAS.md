# 🏗️ Arquitetura: Usuários e Escolas

## 📋 Visão Geral

Este documento explica como funciona o sistema de usuários, escolas e permissões no sistema RFID Escolar.

---

## 🔄 Fluxo de Dados

### 1. **Escolas vêm da API iTAG** 🏫

```
API iTAG Monitor → Detecta Tag → AutoCadastroService → Cria Escola Automaticamente
```

- As **escolas são criadas automaticamente** quando tags RFID são detectadas
- Os dados vêm do campo `extra1` das tags (nome da escola)
- **NÃO é possível criar ou excluir escolas manualmente**
- **É possível apenas EDITAR** para adicionar:
  - Logomarca
  - Endereço personalizado
  - Status ativo/inativo

### 2. **Usuários e Permissões** 👥

```
Admin → Cria Usuário → Associa à Escola → Usuário acessa apenas dados daquela escola
```

#### Como funciona:

1. **Tabela `users`** tem campo `escola_id` (chave estrangeira para `escolas`)
2. **Middleware `EnsureUserHasEscola`** garante que usuário tenha escola associada
3. **Cada usuário só vê dados da sua escola**

---

## 🎯 Funcionalidades Implementadas

### ✅ CRUD de Escolas (Limitado)

| Ação | Disponível | Observação |
|------|-----------|------------|
| **Listar** | ✅ Sim | Ver todas as escolas do sistema |
| **Visualizar** | ✅ Sim | Ver detalhes e estatísticas |
| **Criar** | ❌ Não | Escolas vêm da API iTAG |
| **Editar** | ✅ Sim | Apenas logo, endereço e status |
| **Excluir** | ❌ Não | Dados dependem da API iTAG |

**Acesso:** Menu → Escolas e Turmas → Escolas  
**URL:** `http://localhost:8000/schools`

---

### ✅ CRUD de Usuários (Completo)

| Ação | Disponível | Observação |
|------|-----------|------------|
| **Listar** | ✅ Sim | Ver todos os usuários |
| **Visualizar** | ✅ Sim | Ver detalhes e escola associada |
| **Criar** | ✅ Sim | Criar novo usuário e associar à escola |
| **Editar** | ✅ Sim | Alterar dados e trocar escola |
| **Excluir** | ✅ Sim | Exceto o próprio usuário logado |

**Acesso:** Menu → Configurações → Usuários  
**URL:** `http://localhost:8000/users`

---

## 🔐 Sistema de Permissões

### Como Associar Usuário a uma Escola:

1. Acesse **Configurações → Usuários**
2. Clique em **Novo Usuário** ou **Editar** usuário existente
3. No campo **"Escola Associada"**, selecione a escola
4. Salve

### O que o usuário pode acessar:

#### ✅ **Com Escola Associada:**
- Dashboard com dados da escola
- Turmas da escola
- Alunos da escola
- Presenças e movimentações
- Relatórios filtrados pela escola

#### ⚠️ **Sem Escola Associada:**
- Acesso limitado
- Não pode ver dados de alunos/turmas
- Dashboard vazio

---

## 📊 Relacionamentos no Banco de Dados

```
users
├── id
├── name
├── email
├── password
└── escola_id (FK → escolas.id)

escolas
├── id
├── nome (criado pela API iTAG)
├── code (criado pela API iTAG)
├── logo (customização manual)
├── address (customização manual)
└── active (customização manual)

turmas
├── id
├── escola_id (FK → escolas.id)
└── nome

alunos
├── id
├── turma_id (FK → turmas.id)
└── nome

tags
├── id
├── epc
└── aluno_id (FK → alunos.id)
```

---

## 🚀 Como Usar o Sistema

### 1️⃣ **Configuração Inicial**

```bash
# 1. Iniciar o servidor Laravel
cd itag-realtime
php artisan serve

# 2. Iniciar a API iTAG Monitor (se disponível)
# Isso fará com que as escolas sejam criadas automaticamente
```

### 2️⃣ **Criar Primeiro Usuário**

```bash
# Via Tinker (console do Laravel)
php artisan tinker

# Criar usuário admin
$user = new App\Models\User();
$user->name = 'Administrador';
$user->email = 'admin@sistema.com';
$user->password = bcrypt('senha123');
$user->save();

# Associar à primeira escola (após ser criada pela API)
$escola = App\Models\Escola::first();
$user->escola_id = $escola->id;
$user->save();
```

### 3️⃣ **Acessar o Sistema**

1. Acesse: `http://localhost:8000/login`
2. Login com o usuário criado
3. Configure logo da escola em: **Escolas → Editar**
4. Crie mais usuários em: **Configurações → Usuários**

---

## 🛠️ Arquivos Principais

### Controllers:
- `app/Http/Controllers/SchoolController.php` - CRUD de escolas
- `app/Http/Controllers/UserController.php` - CRUD de usuários
- `app/Http/Controllers/ItagRealtimeController.php` - Integração API iTAG

### Models:
- `app/Models/User.php` - Usuário com relação à escola
- `app/Models/Escola.php` - Escola
- `app/Models/School.php` - Alias para Escola (tabela schools)

### Services:
- `app/Services/AutoCadastroService.php` - **CRIA ESCOLAS AUTOMATICAMENTE**
- `app/Services/AntennaResolver.php` - Resolve antenas por escola

### Middleware:
- `app/Http/Middleware/EnsureUserHasEscola.php` - Garante que usuário tem escola

### Migrations:
- `2025_11_08_183644_add_escola_id_to_users_table.php` - Adiciona escola ao usuário
- `2025_11_10_161754_add_logo_to_schools_table.php` - Adiciona logo às escolas

---

## 💡 Dicas Importantes

### ⚠️ **NÃO fazer:**
- ❌ Não tente criar escolas manualmente no sistema
- ❌ Não delete escolas (elas têm dados associados)
- ❌ Não deixe usuários sem escola associada

### ✅ **FAZER:**
- ✅ Deixe a API iTAG criar as escolas automaticamente
- ✅ Use o CRUD de escolas apenas para adicionar logo e customizações
- ✅ Sempre associe usuários a uma escola
- ✅ Use o dashboard para monitorar dados em tempo real

---

## 🔧 Troubleshooting

### Problema: "Usuário sem escola não pode acessar o sistema"
**Solução:** Edite o usuário e associe-o a uma escola existente.

### Problema: "Nenhuma escola aparece no sistema"
**Solução:** 
1. Verifique se a API iTAG Monitor está rodando
2. Detecte algumas tags para criar escolas automaticamente
3. Ou crie escolas via Tinker para testes:

```php
php artisan tinker

App\Models\Escola::create([
    'nome' => 'ESCOLA TESTE',
    'code' => 'ESC001'
]);
```

### Problema: "Logo da escola não está aparecendo"
**Solução:**
1. Verifique se o storage está linkado: `php artisan storage:link`
2. Verifique permissões da pasta `storage/app/public`

---

## 📝 Resumo

| Característica | Valor |
|---------------|-------|
| **Escolas** | Criadas automaticamente pela API iTAG |
| **Usuários** | Criados manualmente pelo admin |
| **Permissões** | Por escola (1 usuário = 1 escola) |
| **Logo** | Upload manual via CRUD de escolas |
| **Middleware** | `EnsureUserHasEscola` |

---

## 🎉 Sistema Completo e Funcional!

O sistema agora está totalmente integrado com:
- ✅ Detecção automática de escolas via API iTAG
- ✅ Gerenciamento de usuários com associação a escolas
- ✅ Upload de logomarcas
- ✅ Controle de acesso por escola
- ✅ Interface moderna e responsiva

**Pronto para uso em produção!** 🚀

