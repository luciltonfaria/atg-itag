# 📊 Dados de Teste - iTAG Realtime

## 🏫 Escolas Cadastradas

### 1. Escola Municipal João da Silva
- **Código:** ESC001
- **Endereço:** Rua das Flores, 123 - Centro
- **Turmas:** 2 (5º Ano A e 5º Ano B)
- **Total de Alunos:** 10

### 2. Colégio Estadual Maria Santos
- **Código:** ESC002
- **Endereço:** Av. Principal, 456 - Jardim Europa
- **Turmas:** 1 (6º Ano A)
- **Total de Alunos:** 5

---

## 📚 Turmas e Alunos

### 🔵 5º Ano A - Escola Municipal João da Silva

| Aluno | Matrícula | Data Nasc. | EPC (Tag RFID) |
|-------|-----------|------------|----------------|
| Ana Carolina Silva | ALU2025001 | 15/03/2015 | E28011700000020000000001 |
| Bruno Santos Oliveira | ALU2025002 | 22/05/2015 | E28011700000020000000002 |
| Carla Fernandes Costa | ALU2025003 | 10/01/2015 | E28011700000020000000003 |
| Daniel Rodrigues Lima | ALU2025004 | 08/07/2015 | E28011700000020000000004 |
| Eduarda Martins Souza | ALU2025005 | 30/09/2015 | E28011700000020000000005 |

### 🟢 5º Ano B - Escola Municipal João da Silva

| Aluno | Matrícula | Data Nasc. | EPC (Tag RFID) |
|-------|-----------|------------|----------------|
| Felipe Alves Pereira | ALU2025006 | 18/02/2015 | E28011700000020000000006 |
| Gabriela Rocha Santos | ALU2025007 | 25/06/2015 | E28011700000020000000007 |
| Henrique Costa Silva | ALU2025008 | 12/04/2015 | E28011700000020000000008 |
| Isabela Lima Oliveira | ALU2025009 | 07/08/2015 | E28011700000020000000009 |
| João Pedro Souza | ALU2025010 | 20/11/2015 | E28011700000020000000010 |

### 🟡 6º Ano A - Colégio Estadual Maria Santos

| Aluno | Matrícula | Data Nasc. | EPC (Tag RFID) |
|-------|-----------|------------|----------------|
| Larissa Fernandes Martins | ALU2025011 | 05/03/2014 | E28011700000020000000011 |
| Mateus Silva Costa | ALU2025012 | 15/09/2014 | E28011700000020000000012 |
| Natália Santos Lima | ALU2025013 | 28/01/2014 | E28011700000020000000013 |
| Pedro Henrique Rocha | ALU2025014 | 10/06/2014 | E28011700000020000000014 |
| Rafaela Oliveira Souza | ALU2025015 | 03/12/2014 | E28011700000020000000015 |

---

## 🧪 Como Testar

### 1. Popular o Banco de Dados

```bash
php artisan db:seed --class=TestDataSeeder
```

### 2. Iniciar o Servidor Laravel

```bash
php artisan serve
```

### 3. Acessar a Interface de Monitoramento

Abra no navegador: `http://localhost:8000/demo.html`

### 4. Testar com o iTAG Monitor

1. Certifique-se de que o **iTAG Monitor** está rodando em `http://localhost:9093/ItagRFIDMonitor`
2. Clique em **"▶️ Iniciar Monitoramento"** na interface
3. Apresente as tags RFID ao leitor
4. A interface mostrará:
   - ✅ **Tags cadastradas:** Nome do aluno, matrícula, turma e escola
   - ⚠️ **Tags não cadastradas:** Alerta de tag desconhecida

---

## 📡 Endpoints da API

### Comandos do Monitor

- **POST** `/api/itag/start` - Inicia leitura do monitor
- **POST** `/api/itag/stop` - Para leitura do monitor
- **POST** `/api/itag/clear` - Limpa buffer de leitura

### Consultas

- **GET** `/api/itag/tags` - Retorna snapshot atual (tags + timestamp)
- **GET** `/api/itag/stream` - Stream SSE em tempo real

---

## 🔍 Exemplo de Resposta da API

### Quando uma tag cadastrada é lida:

```json
{
  "epc": "E28011700000020000000001",
  "rssi": -45,
  "antenna": 1,
  "time": "2025-11-08T17:30:45.123Z",
  "student": {
    "id": 1,
    "name": "Ana Carolina Silva",
    "code": "ALU2025001",
    "class": {
      "id": 1,
      "name": "5º Ano A",
      "year": "2025"
    },
    "school": {
      "id": 1,
      "name": "Escola Municipal João da Silva",
      "code": "ESC001"
    }
  }
}
```

### Quando uma tag NÃO cadastrada é lida:

```json
{
  "epc": "E999999999999999",
  "rssi": -50,
  "antenna": 2,
  "time": "2025-11-08T17:31:10.456Z",
  "student": null
}
```

---

## 🗄️ Estrutura do Banco de Dados

```
schools (escolas)
  └─ classes (turmas)
      └─ students (alunos)
          └─ student_tags (tags RFID)

movement_events (histórico de leituras)
```

### Relacionamentos:

- Uma **escola** tem várias **turmas**
- Uma **turma** tem vários **alunos**
- Um **aluno** pode ter várias **tags** (histórico)
- Apenas uma tag por aluno está **ativa** por vez

---

## ✅ Funcionalidades Implementadas

- ✅ Estrutura completa de escolas, turmas e alunos
- ✅ Associação de tags RFID aos alunos
- ✅ Identificação automática de alunos nas leituras
- ✅ Interface visual moderna com status em tempo real
- ✅ Histórico de movimentações salvo no banco
- ✅ SSE (Server-Sent Events) para streaming em tempo real
- ✅ Tratamento de tags não cadastradas
- ✅ 15 alunos de teste distribuídos em 3 turmas e 2 escolas

---

## 🎯 Próximos Passos Sugeridos

1. **Dashboard de Relatórios**: Criar interface para consultar histórico de movimentações
2. **Alertas**: Notificar quando alunos específicos são detectados
3. **Controle de Presença**: Registrar entrada/saída automaticamente
4. **Gestão de Tags**: Interface para cadastrar/editar alunos e tags
5. **Exportação**: Gerar relatórios em PDF/Excel
6. **Múltiplos Leitores**: Suporte para identificar local de leitura (portaria, sala, etc.)

---

## 📞 Comandos Úteis

```bash
# Resetar e popular banco novamente
php artisan migrate:fresh --seed --seeder=TestDataSeeder

# Ver estrutura das tabelas
php artisan tinker
>>> Schema::getColumnListing('students')

# Consultar alunos e suas tags
php artisan tinker
>>> App\Models\Student::with(['class.school', 'tags'])->get()

# Verificar tag específica
php artisan tinker
>>> App\Models\StudentTag::where('epc', 'E28011700000020000000001')->with('student.class.school')->first()
```


