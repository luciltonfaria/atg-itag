# 🔧 Solução de Problemas - iTAG Realtime

## ⚡ IMPORTANTE: Os Relatórios NÃO Dependem da API Externa!

### ✅ O que funciona SEM o iTAG Monitor:

- ✅ **Login/Logout** → 100% funcional
- ✅ **Dashboard** → 100% funcional
- ✅ **Todos os 5 Relatórios** → 100% funcionais
  - Movimentação por Aluno
  - Movimentação por Turma
  - Movimentação Geral
  - Faltas por Turma
  - Faltas Geral

**Esses recursos consultam APENAS o banco de dados MySQL!**

### ❌ O que precisa do iTAG Monitor (opcional):

- ❌ **SSE Stream** (`/api/itag/stream`) → Tempo real
- ❌ **Comandos do Monitor** (`/api/itag/start`, `/api/itag/stop`)
- ❌ **Demo.html** → Página de demonstração SSE

---

## 🐛 Problema 1: "Could not open input file: artisan"

### Causa:
Você está executando `php artisan` fora do diretório do projeto.

### Solução:

```bash
# 1. Navegue para o diretório correto
cd itag-realtime

# 2. Verifique se está no lugar certo
dir artisan

# 3. Agora sim, inicie o servidor
php artisan serve
```

---

## 🐛 Problema 2: Sistema Lento / Timeout

### Causa:
O sistema estava tentando conectar com `http://localhost:9093/ItagRFIDMonitor` com timeout de 5 segundos.

### Solução Aplicada:

✅ **Já corrigido!** Agora os timeouts são:
- **Timeout total:** 2 segundos
- **Timeout de conexão:** 1 segundo
- **Tratamento de erro:** Retorna mensagem clara

### Código Otimizado:

```php
// ANTES (lento - 5 segundos)
$res = Http::timeout(5)->get($url);

// DEPOIS (rápido - 1-2 segundos)
try {
    $res = Http::timeout(2)->connectTimeout(1)->get($url);
} catch (\Exception $e) {
    return response()->json(['error' => 'Monitor offline'], 503);
}
```

---

## 🐛 Problema 3: iTAG Monitor Não Disponível

### O que fazer:

#### Opção 1: Usar APENAS os Relatórios (Recomendado)

Os relatórios funcionam perfeitamente sem o iTAG Monitor!

```bash
cd itag-realtime
php artisan serve
```

Acesse: `http://localhost:8000/login`

**Use os 5 relatórios normalmente!** Eles consultam o banco de dados.

#### Opção 2: Iniciar o iTAG Monitor (Se necessário)

Se você precisa do SSE/Stream em tempo real:

1. Certifique-se de que o iTAG Monitor está rodando
2. Deve estar disponível em: `http://localhost:9093/ItagRFIDMonitor`
3. Verifique no `.env`:

```env
ITAG_MONITOR_BASE=http://localhost:9093/ItagRFIDMonitor
```

---

## 🐛 Problema 4: Servidor Não Inicia

### Causa 1: Porta 8000 já em uso

```bash
# Use outra porta
php artisan serve --port=8001
```

Acesse: `http://localhost:8001`

### Causa 2: PHP não encontrado

```bash
# Verifique se PHP está instalado
php -v

# Se não estiver, instale PHP 8.2+
```

---

## 🐛 Problema 5: Erro de Banco de Dados

### Verifique `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=itag_realtime
DB_USERNAME=root
DB_PASSWORD=sua_senha_aqui
```

### Execute migrations:

```bash
cd itag-realtime
php artisan migrate
```

### Popule dados de teste:

```bash
php artisan db:seed --class=CompleteDatabaseSeeder
php artisan db:seed --class=UsersSeeder
```

---

## 🐛 Problema 6: Não Consigo Fazer Login

### Verifique se os usuários foram criados:

```bash
php artisan db:seed --class=UsersSeeder
```

### Credenciais padrão:

```
Email: escolaa@itag.com
Senha: senha123
```

---

## 🐛 Problema 7: Relatórios Sem Dados

### Verifique se há dados no banco:

```bash
php artisan db:seed --class=CompleteDatabaseSeeder
```

Isso cria:
- 4 escolas
- ~16 turmas
- ~240 alunos
- Centenas de movimentações

---

## ⚙️ Comandos Úteis

### Iniciar servidor:
```bash
cd itag-realtime
php artisan serve
```

### Recriar banco (cuidado - apaga tudo):
```bash
php artisan migrate:fresh
```

### Popular dados:
```bash
php artisan db:seed --class=CompleteDatabaseSeeder
php artisan db:seed --class=UsersSeeder
```

### Limpar cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Ver rotas disponíveis:
```bash
php artisan route:list
```

---

## 🔍 Diagnóstico Rápido

### 1. Verifique o diretório:
```bash
pwd
# Deve mostrar: .../itag-realtime
```

### 2. Verifique se artisan existe:
```bash
dir artisan
# ou
ls artisan
```

### 3. Teste o banco:
```bash
php artisan tinker
# Dentro do tinker:
DB::connection()->getPdo();
# Se funcionar, conexão OK!
```

### 4. Teste login:
```bash
php artisan tinker
# Dentro do tinker:
\App\Models\User::count();
# Deve retornar: 5 (4 escolas + 1 admin)
```

---

## 📊 Performance Esperada

### Com iTAG Monitor OFFLINE (normal):

| Ação | Tempo Esperado |
|------|----------------|
| Login | < 1 segundo |
| Dashboard | < 1 segundo |
| Relatórios | 1-2 segundos |
| Filtros | < 1 segundo |

### Com iTAG Monitor ONLINE:

| Ação | Tempo Esperado |
|------|----------------|
| SSE Stream | Tempo real |
| Comandos | < 2 segundos |

---

## ✅ Checklist de Verificação

Antes de relatar um problema, verifique:

- [ ] Estou no diretório `itag-realtime`?
- [ ] O arquivo `artisan` existe?
- [ ] PHP está instalado? (`php -v`)
- [ ] MySQL está rodando?
- [ ] As credenciais do `.env` estão corretas?
- [ ] Executei `php artisan migrate`?
- [ ] Executei `php artisan db:seed --class=UsersSeeder`?
- [ ] Estou usando a porta correta? (8000 padrão)

---

## 🎯 Solução Rápida: Começar do Zero

Se nada funcionar, faça um reset completo:

```bash
# 1. Entre no diretório
cd itag-realtime

# 2. Recrie o banco
php artisan migrate:fresh

# 3. Popule dados
php artisan db:seed --class=CompleteDatabaseSeeder
php artisan db:seed --class=UsersSeeder

# 4. Limpe cache
php artisan cache:clear
php artisan config:clear

# 5. Inicie servidor
php artisan serve
```

Acesse: `http://localhost:8000/login`

Login: `escolaa@itag.com` | Senha: `senha123`

---

## 💡 Dica Final

**Os relatórios são 100% independentes da API externa!**

Mesmo se o iTAG Monitor estiver offline, você pode:
- ✅ Fazer login
- ✅ Ver dashboard
- ✅ Usar todos os 5 relatórios
- ✅ Filtrar por turma/aluno/período
- ✅ Ver faltas

**Tudo funciona perfeitamente consultando o banco de dados local!** 🚀

---

## 📞 Resumo das Otimizações Aplicadas

✅ **Timeout reduzido:** 5s → 1-2s  
✅ **Tratamento de erro:** Mensagens claras quando Monitor offline  
✅ **Relatórios independentes:** Não usam API externa  
✅ **Performance melhorada:** Resposta rápida mesmo com Monitor offline  

**Sistema agora é RÁPIDO mesmo sem o iTAG Monitor!** ⚡


