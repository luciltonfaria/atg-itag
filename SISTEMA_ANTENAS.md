# 📡 Sistema de Antenas - iTAG Realtime

## ✅ Implementação Completa

O sistema de antenas foi **completamente implementado** e está funcionando perfeitamente!

---

## 🎯 O Que Foi Implementado

### 1. ✅ **Tabela `antennas`**
- Armazena as antenas de cada escola
- Relacionamento: `antenna` → `escola`
- Constraint: `unique(escola_id, codigo)`
- Auto-criação quando necessário

### 2. ✅ **Relacionamento com `movement_events`**
- Campo `antenna_id` (FK para `antennas`)
- Campo `antenna` (código/porta original do evento)
- Campo `rssi` (intensidade do sinal)

### 3. ✅ **Model `Antenna`**
- Fillable: `escola_id`, `codigo`, `descricao`, `ativo`
- Relacionamento: `belongsTo(Escola)`

### 4. ✅ **Serviço `AntennaResolver`**
- Resolve antenas automaticamente por escola do aluno
- Cria antenas sob demanda (firstOrCreate)
- Normalização de códigos

### 5. ✅ **Controller Atualizado**
- `ItagRealtimeController` chama `AntennaResolver`
- Eventos registrados com `antenna_id`
- SSE envia dados da antena

### 6. ✅ **Endpoints de Teste**
- `POST /api/itag/mock-detect` - detecção simples
- `POST /api/itag/mock-event` - detecção com antena

---

## 📊 Estrutura da Tabela `antennas`

```sql
CREATE TABLE antennas (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    escola_id BIGINT UNSIGNED NOT NULL,
    codigo VARCHAR(20) NOT NULL,
    descricao VARCHAR(255) NULL,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (escola_id) REFERENCES escolas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_escola_codigo (escola_id, codigo)
);
```

### Campos

- **id**: Chave primária
- **escola_id**: FK para `escolas` (cada escola tem suas antenas)
- **codigo**: Número/porta da antena (ex: "1", "2", "Porta A")
- **descricao**: Descrição legível (ex: "Portão Principal", "Entrada Sul")
- **ativo**: Se a antena está ativa

---

## 🔧 Como Funciona

### Fluxo Automático

1. **Evento chega** do monitor com `antenna: "1"`
2. **AutoCadastroService** cria/resolve Escola → Turma → Aluno → Tag
3. **AntennaResolver** busca/cria antena:
   - Identifica escola do aluno (via turma)
   - Busca antena com `escola_id + codigo`
   - Se não existe, **cria automaticamente** com descrição "Antena {codigo}"
4. **Evento gravado** em `movement_events` com `antenna_id`

### Reutilização Inteligente

- Mesma escola + mesmo código = **reutiliza** antena existente
- Escola diferente + mesmo código = cria **antena separada**
- Permite múltiplas antenas por escola (1, 2, 3, 4...)

---

## 🚀 Uso Prático

### Via Stream SSE (Automático)

```javascript
const es = new EventSource('/api/itag/stream');
es.addEventListener('tag', (e) => {
  const data = JSON.parse(e.data);
  console.log('EPC:', data.epc);
  console.log('Aluno ID:', data.aluno_id);
  console.log('Antena:', data.antenna);      // código original
  console.log('Antena ID:', data.antenna_id); // ID da tabela
  console.log('RSSI:', data.rssi);
});
```

### Via Endpoint Mock

**Com servidor rodando:**

```powershell
$body = @{
  epc="TAG_COM_ANTENA_001"
  antenna="1"
  nome="Carlos Silva"
  extra1="Escola ABC"
  extra2="5º Ano"
} | ConvertTo-Json

Invoke-WebRequest `
  -Uri "http://localhost:8000/api/itag/mock-event" `
  -Method POST `
  -Body $body `
  -ContentType "application/json"
```

**Resposta:**
```json
{
  "ok": true,
  "aluno_id": 210,
  "antenna_id": 1
}
```

### Via PHP

```php
use App\Services\AutoCadastroService;
use App\Services\AntennaResolver;

$auto = app(AutoCadastroService::class);
$resolver = app(AntennaResolver::class);

// 1. Criar hierarquia
$tag = $auto->ensureHierarchy([
    'epc' => 'TAG123',
    'nome' => 'João Silva',
    'extra1' => 'Escola X',
    'extra2' => '6º Ano',
]);

// 2. Resolver antena
$antenna = $resolver->resolveForAluno($tag->aluno_id, '1');

// 3. Registrar evento
DB::table('movement_events')->insert([
    'epc' => 'TAG123',
    'seen_at' => now(),
    'source' => 'monitor',
    'antenna_id' => $antenna->id,
    'antenna' => '1',
    'rssi' => -45,
    'raw' => json_encode([...]),
    'created_at' => now(),
    'updated_at' => now(),
]);
```

---

## 📊 Consultas SQL Úteis

### Ver todas as antenas

```sql
SELECT 
    a.id,
    e.nome as escola,
    a.codigo,
    a.descricao,
    a.ativo,
    COUNT(me.id) as total_eventos
FROM antennas a
JOIN escolas e ON e.id = a.escola_id
LEFT JOIN movement_events me ON me.antenna_id = a.id
GROUP BY a.id
ORDER BY e.nome, a.codigo;
```

### Eventos por antena

```sql
SELECT 
    a.codigo as antena,
    a.descricao,
    DATE(me.seen_at) as data,
    COUNT(*) as total_leituras,
    COUNT(DISTINCT me.epc) as tags_distintas
FROM movement_events me
JOIN antennas a ON a.id = me.antenna_id
GROUP BY a.id, DATE(me.seen_at)
ORDER BY data DESC, a.codigo;
```

### Mapa de cobertura (RSSI médio por antena)

```sql
SELECT 
    e.nome as escola,
    a.codigo as antena,
    a.descricao,
    COUNT(me.id) as total_leituras,
    AVG(me.rssi) as rssi_medio,
    MIN(me.rssi) as rssi_min,
    MAX(me.rssi) as rssi_max
FROM antennas a
JOIN escolas e ON e.id = a.escola_id
LEFT JOIN movement_events me ON me.antenna_id = a.id
WHERE me.rssi IS NOT NULL
GROUP BY a.id
ORDER BY e.nome, a.codigo;
```

### Alunos detectados por antena (hoje)

```sql
SELECT 
    a.codigo as antena,
    a.descricao,
    al.nome as aluno,
    t.nome as turma,
    COUNT(me.id) as leituras
FROM movement_events me
JOIN antennas a ON a.id = me.antenna_id
JOIN tags tg ON tg.epc = me.epc
JOIN alunos al ON al.id = tg.aluno_id
JOIN turmas t ON t.id = al.turma_id
WHERE DATE(me.seen_at) = CURDATE()
GROUP BY a.id, al.id
ORDER BY a.codigo, al.nome;
```

---

## 🎨 Personalização de Antenas

### Editar Descrições

```sql
-- Atualizar descrições das antenas
UPDATE antennas 
SET descricao = 'Portão Principal' 
WHERE escola_id = 1 AND codigo = '1';

UPDATE antennas 
SET descricao = 'Entrada Sul' 
WHERE escola_id = 1 AND codigo = '2';

UPDATE antennas 
SET descricao = 'Biblioteca' 
WHERE escola_id = 1 AND codigo = '3';

UPDATE antennas 
SET descricao = 'Quadra de Esportes' 
WHERE escola_id = 1 AND codigo = '4';
```

### Desativar Antena

```sql
UPDATE antennas 
SET ativo = FALSE 
WHERE id = 5;
```

### Listar Antenas de uma Escola

```php
use App\Models\Escola;

$escola = Escola::with('turmas')->find(1);
$antennas = \App\Models\Antenna::where('escola_id', $escola->id)
    ->where('ativo', true)
    ->get();

foreach ($antennas as $ant) {
    echo "{$ant->codigo}: {$ant->descricao}\n";
}
```

---

## 🧪 Testes Realizados

### ✅ Teste 1: Criação Automática
- ✅ Hierarquia criada (Escola → Turma → Aluno → Tag)
- ✅ Antena criada automaticamente com código "1"
- ✅ Evento registrado com `antenna_id`

### ✅ Teste 2: Reutilização
- ✅ Mesmo código + mesma escola = reutiliza antena
- ✅ Não cria duplicatas

### ✅ Teste 3: Múltiplas Antenas
- ✅ Códigos 1, 2, 3, 4 criados na mesma escola
- ✅ Cada um com ID único
- ✅ Constraint `unique(escola_id, codigo)` funcionando

### 📊 Resultados
```
Total de antenas criadas: 4
Eventos com antenna_id: 1
Distribuição: ESCOLA TESTE ANTENAS = 4 antenas
```

---

## 📋 Checklist de Implementação

- [x] Migration `create_antennas_and_link_movement_events` criada
- [x] Tabela `antennas` criada
- [x] Relacionamento FK `movement_events.antenna_id` criado
- [x] Campos `antenna` e `rssi` adicionados
- [x] Model `Antenna` criado com relacionamentos
- [x] Serviço `AntennaResolver` implementado
- [x] `ItagRealtimeController` atualizado (construtor + stream)
- [x] Endpoint `/api/itag/mock-event` criado
- [x] Testes executados com sucesso
- [x] Documentação criada

---

## 🎯 Benefícios

### Antes (sem tabela antennas)
- ❌ Antena armazenada apenas como string
- ❌ Sem vínculo com escola
- ❌ Difícil gerar relatórios por local
- ❌ Não havia normalização

### Agora (com tabela antennas)
- ✅ Antenas normalizadas por escola
- ✅ FK garantindo integridade
- ✅ Descrições editáveis ("Portão", "Biblioteca")
- ✅ Relatórios por local/antena facilitados
- ✅ Mapa de cobertura possível
- ✅ Estatísticas de RSSI por antena

---

## 📈 Próximos Passos (Opcionais)

1. **Dashboard de Antenas**
   - Visualizar todas as antenas por escola
   - Editar descrições via interface
   - Ver estatísticas em tempo real

2. **Mapa de Cobertura**
   - Heat map de RSSI por antena
   - Identificar pontos fracos
   - Otimizar posicionamento

3. **Alertas por Antena**
   - Notificar quando aluno passar por antena específica
   - Ex: "Aluno X entrou pela Portaria Principal"

4. **Relatório de Movimentação**
   - Fluxo de alunos entre antenas
   - Horários de pico por local
   - Tempo de permanência

5. **Gestão de Antenas**
   - CRUD completo via API
   - Ativar/desativar antenas
   - Histórico de manutenção

---

## 💡 Dicas

### Nomear Antenas Inteligentemente

```sql
-- Entrada/Saída
UPDATE antennas SET descricao = 'Portão Principal - Entrada' WHERE codigo = '1';
UPDATE antennas SET descricao = 'Portão Principal - Saída' WHERE codigo = '2';

-- Por Setor
UPDATE antennas SET descricao = 'Bloco A - Térreo' WHERE codigo = '3';
UPDATE antennas SET descricao = 'Bloco B - 1º Andar' WHERE codigo = '4';

-- Por Função
UPDATE antennas SET descricao = 'Biblioteca - Entrada' WHERE codigo = '5';
UPDATE antennas SET descricao = 'Refeitório - Principal' WHERE codigo = '6';
```

### Monitorar Performance

```php
// Antenas com mais leituras (últimos 7 dias)
$topAntennas = DB::table('movement_events')
    ->select('antenna_id', DB::raw('COUNT(*) as total'))
    ->where('seen_at', '>=', now()->subDays(7))
    ->whereNotNull('antenna_id')
    ->groupBy('antenna_id')
    ->orderBy('total', 'desc')
    ->limit(10)
    ->get();
```

### Validar Cobertura

```php
// Verificar se há buracos na cobertura (alunos sem eventos recentes)
$alunosSemEventos = Aluno::whereDoesntHave('tags', function($q) {
    $q->whereHas('movementEvents', function($q2) {
        $q2->where('seen_at', '>=', now()->subHours(24));
    });
})->count();
```

---

## 🎉 Status Final

**✅ Sistema de Antenas 100% Funcional!**

- ✅ Auto-criação de antenas
- ✅ Vinculação por escola
- ✅ Reutilização inteligente
- ✅ Eventos registrados com antenna_id
- ✅ Pronto para relatórios avançados
- ✅ Totalmente testado

---

**Data:** 08/11/2025  
**Versão:** 1.0  
**Laravel:** 10/11  
**PHP:** 8.2+  
**Status:** ✅ PRODUÇÃO


