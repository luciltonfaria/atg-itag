# 🤖 Sistema de Auto-Cadastro - iTAG Realtime

## 📋 Visão Geral

O sistema de auto-cadastro permite que alunos, turmas e escolas sejam **criados automaticamente** quando uma tag RFID é detectada, sem necessidade de cadastro prévio manual.

### ✨ Características

- ✅ **Auto-criação**: Escola, Turma, Aluno e Tag criados automaticamente
- ✅ **Normalização**: Todos os textos são normalizados (uppercase, trim, espaços duplicados)
- ✅ **Transacional**: Operações atômicas com rollback em caso de erro
- ✅ **Placeholders inteligentes**: Quando dados não estão disponíveis, usa valores padrão
- ✅ **Re-atribuição**: Se uma tag já existe para outro aluno (uniforme trocado), realoca automaticamente
- ✅ **Compatibilidade**: Funciona junto com a estrutura antiga (schools/students)

---

## 🗄️ Estrutura do Banco de Dados

```
escolas (id, nome, timestamps)
  └─ turmas (id, escola_id, nome, timestamps)
      └─ alunos (id, turma_id, nome, referencia, timestamps)
          └─ tags (id, epc, aluno_id, ativo, timestamps)
```

### Tabelas Criadas

#### `escolas`
- `id` - Chave primária
- `nome` - Nome da escola (único, max 120 chars)
- `timestamps`

#### `turmas`
- `id` - Chave primária
- `escola_id` - FK para escolas (cascade delete)
- `nome` - Nome da turma (max 120 chars)
- Unique: `[escola_id, nome]`

#### `alunos`
- `id` - Chave primária
- `turma_id` - FK para turmas (cascade delete)
- `nome` - Nome do aluno (max 160 chars)
- `referencia` - CPF ou matrícula (nullable, max 60 chars)
- Unique: `[turma_id, nome]`

#### `tags`
- `id` - Chave primária
- `epc` - Código RFID (único, max 64 chars)
- `aluno_id` - FK para alunos (cascade delete)
- `ativo` - Boolean (default true)

---

## 🔧 Como Funciona

### Payload Esperado

O serviço `AutoCadastroService` espera os seguintes campos:

```php
[
    'epc'        => 'E28011700000020ABC123',  // OBRIGATÓRIO
    'nome'       => 'João da Silva',           // Nome do aluno (opcional)
    'referencia' => '12345678901',             // CPF/matrícula (opcional)
    'extra1'     => 'Escola Alfa',             // Nome da escola (opcional)
    'extra2'     => '6º Ano A',                // Nome da turma (opcional)
]
```

### Comportamento com Campos Faltantes

Quando campos não são fornecidos, o sistema usa **placeholders**:

| Campo Ausente | Placeholder Usado |
|---------------|-------------------|
| `extra1` (escola) | `ESCOLA DESCONHECIDA` |
| `extra2` (turma) | `SEM TURMA` |
| `nome` (aluno) | `ALUNO NÃO IDENTIFICADO` |
| `referencia` | `null` |

### Normalização de Texto

Todos os textos passam por `TextNormalizer::up()`:

```php
// Antes
"  escola   alfa  "  → "ESCOLA ALFA"
"João da Silva"      → "JOÃO DA SILVA"
"6º ano  A"          → "6º ANO A"
```

---

## 🚀 Uso do Sistema

### 1. Via Stream SSE (Automático)

O controller `ItagRealtimeController` já chama o auto-cadastro automaticamente:

```php
// Quando uma tag é lida do monitor
GET /api/itag/stream

// O sistema automaticamente:
// 1. Detecta o EPC
// 2. Busca dados extras (nome, escola, turma)
// 3. Cria/atualiza registros
// 4. Envia evento SSE
```

### 2. Via Endpoint Mock (Teste Manual)

Para testar sem hardware RFID:

```bash
curl -X POST http://localhost:8000/api/itag/mock-detect \
  -H "Content-Type: application/json" \
  -d '{
    "epc": "3036E7D8915AD7550000ABCD",
    "nome": "Lucas Andrade",
    "referencia": "12345678901",
    "extra1": "Escola Alfa",
    "extra2": "6º A"
  }'
```

**Resposta:**
```json
{
  "ok": true,
  "tag_id": 1
}
```

### 3. Via Código PHP

```php
use App\Services\AutoCadastroService;

$auto = app(AutoCadastroService::class);

$tag = $auto->ensureHierarchy([
    'epc' => 'E28011700000020XYZ789',
    'nome' => 'Maria Santos',
    'referencia' => '98765432100',
    'extra1' => 'Colégio Beta',
    'extra2' => '5º Ano B',
]);

// Retorna o model Tag com aluno_id preenchido
echo "Tag criada com ID: " . $tag->id;
echo "Aluno ID: " . $tag->aluno_id;
```

---

## 📊 Exemplos de Uso

### Exemplo 1: Tag Completa (com todos os dados)

**Request:**
```json
{
  "epc": "E28011700000020001234",
  "nome": "Pedro Henrique Silva",
  "referencia": "2025001",
  "extra1": "Escola Municipal Centro",
  "extra2": "7º Ano A"
}
```

**Resultado no Banco:**
```
escola: ESCOLA MUNICIPAL CENTRO
  └─ turma: 7º ANO A
      └─ aluno: PEDRO HENRIQUE SILVA (referencia: 2025001)
          └─ tag: E28011700000020001234
```

### Exemplo 2: Tag Mínima (só EPC)

**Request:**
```json
{
  "epc": "E28011700000020UNKNOWN"
}
```

**Resultado no Banco:**
```
escola: ESCOLA DESCONHECIDA
  └─ turma: SEM TURMA
      └─ aluno: ALUNO NÃO IDENTIFICADO
          └─ tag: E28011700000020UNKNOWN
```

### Exemplo 3: Tag Já Existente (Re-atribuição)

**Request 1:**
```json
{
  "epc": "E28011700000020ABC999",
  "nome": "João Silva",
  "extra1": "Escola A",
  "extra2": "5º A"
}
```

**Request 2 (mesmo EPC, aluno diferente):**
```json
{
  "epc": "E28011700000020ABC999",
  "nome": "Maria Costa",
  "extra1": "Escola A",
  "extra2": "6º B"
}
```

**Resultado:** A tag é **reatribuída** para Maria Costa (uniforme trocado de aluno).

---

## 🔍 Consultas Úteis

### Listar Todas as Escolas e suas Turmas

```bash
php artisan tinker
>>> App\Models\Escola::with('turmas')->get()
```

### Buscar Aluno por Tag EPC

```bash
php artisan tinker
>>> $tag = App\Models\Tag::where('epc', 'E28011700000020001234')->first();
>>> $aluno = $tag->aluno;
>>> echo $aluno->nome;
>>> echo $aluno->turma->nome;
>>> echo $aluno->turma->escola->nome;
```

### Ver Todos os Alunos de uma Escola

```bash
php artisan tinker
>>> $escola = App\Models\Escola::where('nome', 'ESCOLA ALFA')->first();
>>> foreach($escola->turmas as $turma) {
...   foreach($turma->alunos as $aluno) {
...     echo "$aluno->nome ($turma->nome)\n";
...   }
... }
```

---

## 🧪 Testando o Sistema

### 1. Testar Auto-Cadastro Básico

```bash
curl -X POST http://localhost:8000/api/itag/mock-detect \
  -H "Content-Type: application/json" \
  -d '{
    "epc": "TEST001",
    "nome": "Aluno Teste 1",
    "extra1": "Escola Teste",
    "extra2": "Turma Teste"
  }'
```

### 2. Testar com Dados Mínimos

```bash
curl -X POST http://localhost:8000/api/itag/mock-detect \
  -H "Content-Type: application/json" \
  -d '{"epc": "TEST002"}'
```

### 3. Verificar no Banco

```sql
-- Ver escolas criadas
SELECT * FROM escolas;

-- Ver alunos e suas tags
SELECT a.nome, a.referencia, t.epc, tu.nome as turma, e.nome as escola
FROM alunos a
JOIN tags t ON t.aluno_id = a.id
JOIN turmas tu ON tu.id = a.turma_id
JOIN escolas e ON e.id = tu.escola_id;

-- Ver eventos de movimento
SELECT * FROM movement_events ORDER BY seen_at DESC LIMIT 10;
```

---

## 🔄 Integração com iPRINT/Inventário

Quando o monitor retornar dados do inventário iPRINT, os campos virão preenchidos:

```json
{
  "epc": "E28011700000020PRINT001",
  "nome": "JOÃO DA SILVA",          // do inventário
  "referencia": "12345678901",       // CPF do inventário
  "extra1": "ESCOLA MUNICIPAL ALFA", // do inventário
  "extra2": "6º ANO A",              // do inventário
  "rssi": -45,
  "antenna": 1
}
```

O auto-cadastro criará/atualizará automaticamente todos os registros.

---

## ⚙️ Configurações e Customizações

### Alterar Placeholders Padrão

Edite `app/Services/AutoCadastroService.php`:

```php
$nomeEscola = TextNormalizer::up($payload['extra1'] ?? 'MINHA ESCOLA PADRÃO');
$nomeTurma  = TextNormalizer::up($payload['extra2'] ?? 'TURMA INDEFINIDA');
$nomeAluno  = TextNormalizer::up($payload['nome']   ?? 'SEM NOME');
```

### Desabilitar Auto-Cadastro

Comente a chamada no `ItagRealtimeController`:

```php
// try {
//     $tagModel = $this->auto->ensureHierarchy($payloadAutoCadastro);
//     $alunoId  = $tagModel->aluno_id;
// } catch (\Throwable $e) {
//     // não impede o evento
// }
```

### Adicionar Validações Extras

Em `AutoCadastroService.php`, adicione validações antes de criar registros:

```php
// Validar CPF
if ($refAluno && !$this->validarCPF($refAluno)) {
    throw new \InvalidArgumentException('CPF inválido');
}

// Limitar tamanho do nome
if (mb_strlen($nomeAluno) < 3) {
    throw new \InvalidArgumentException('Nome muito curto');
}
```

---

## 📝 Checklist de Implementação

✅ Migration criada e executada (`create_escolas_turmas_alunos_tags`)  
✅ Models criados (`Escola`, `Turma`, `Aluno`, `Tag`)  
✅ Helper `TextNormalizer` implementado  
✅ Serviço `AutoCadastroService` criado  
✅ Controller atualizado para chamar auto-cadastro  
✅ Endpoint `/api/itag/mock-detect` funcionando  
✅ Compatibilidade com estrutura antiga mantida  
✅ Testes realizados  

---

## 🎯 Próximos Passos

1. **Dashboard de Gestão**: Interface para visualizar/editar escolas, turmas e alunos
2. **Job de Sincronização**: Enriquecer placeholders com dados do inventário iPRINT
3. **Relatórios**: Consolidar movimentações por aluno/turma/escola
4. **Auditoria**: Log de quando tags são reatribuídas
5. **Multi-tenancy**: Suporte para múltiplas instituições isoladas
6. **API de Consulta**: Endpoints para buscar alunos, turmas, escolas

---

## 💡 Dicas

- **Evite duplicatas**: O sistema usa `firstOrCreate()` para evitar registros duplicados
- **Normalização**: Sempre use `TextNormalizer::up()` ao comparar nomes
- **Transações**: Todo o processo é transacional (all-or-nothing)
- **Performance**: Use `with()` para eager loading ao consultar hierarquias
- **Manutenção**: Periodicamente limpe registros de placeholders não usados

---

## 🐛 Troubleshooting

### Tag não está sendo criada

Verifique se o EPC está sendo enviado:
```bash
tail -f storage/logs/laravel.log
```

### Nomes duplicados

O sistema cria unique constraint em `[turma_id, nome]`. Se quiser permitir duplicatas, remova da migration.

### Performance lenta

Para grandes volumes, adicione índices:
```php
Schema::table('alunos', function (Blueprint $table) {
    $table->index('nome');
    $table->index('referencia');
});
```

---

**Documentação criada em:** 08/11/2025  
**Versão:** 1.0  
**Laravel:** 10/11  
**PHP:** 8.2+


