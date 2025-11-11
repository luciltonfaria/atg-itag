# 🚀 Guia de Início Rápido - iTAG Realtime

## ⚡ 3 Passos para Começar

### 1️⃣ Iniciar o Servidor

```bash
cd itag-realtime
php artisan serve
```

✅ **Servidor iniciado em:** `http://localhost:8000`

---

### 2️⃣ Acessar o Sistema

Abra seu navegador e acesse:

```
http://localhost:8000
```

Você será redirecionado automaticamente para `/login`

---

### 3️⃣ Fazer Login

Use uma das credenciais abaixo:

#### 🏫 Escola A
- **Email:** `escolaa@itag.com`
- **Senha:** `senha123`

#### 🏫 Escola B
- **Email:** `escolab@itag.com`
- **Senha:** `senha123`

#### 🏫 Escola C
- **Email:** `escolac@itag.com`
- **Senha:** `senha123`

#### 🏫 Escola D
- **Email:** `escolad@itag.com`
- **Senha:** `senha123`

---

## 📊 O Que Você Verá

### 1. **Dashboard** (Página Inicial)
- Total de turmas da sua escola
- Total de alunos
- Eventos de hoje
- Alunos detectados hoje
- Links para todos os relatórios

### 2. **Menu Lateral**
- Dashboard
- 📌 Movimentação por Aluno
- 📌 Movimentação por Turma
- 📌 Movimentação Geral
- 📌 Faltas por Turma
- 📌 Faltas Geral

---

## 🎯 Teste Rápido dos Relatórios

### ✅ Teste 1: Ver Movimentação de Um Aluno

1. Clique em **"Movimentação por Aluno"**
2. Selecione uma **Turma** (ex: Turma A1)
3. O sistema carrega automaticamente os alunos
4. Selecione um **Aluno**
5. Defina o período (pode ser hoje: `08/11/2025` a `08/11/2025`)
6. Clique em **Consultar**
7. ✅ **Resultado:** Tabela com todas as movimentações

### ✅ Teste 2: Ver Faltas de Uma Turma

1. Clique em **"Faltas por Turma"**
2. Selecione uma **Turma**
3. Defina o período
4. Clique em **Consultar**
5. ✅ **Resultado:** Lista de alunos ausentes (em vermelho) ou mensagem de sucesso

### ✅ Teste 3: Ver Movimentação Geral

1. Clique em **"Movimentação Geral"**
2. Defina apenas o período
3. Escolha ordenação: **Alfabética** ou **Por Data**
4. Clique em **Consultar**
5. ✅ **Resultado:** Todos os alunos da escola com status (presente/ausente)

---

## 🎨 Recursos Visuais

### 🔴 Destaque para Ausentes
- Linhas **vermelhas** = alunos sem movimentação
- Badge **vermelho** = status "Ausente"

### ✅ Presença
- Linhas **normais** = alunos com movimentação
- Badge **verde** = status "Presente"

---

## 📱 Navegação

### Sidebar (Menu Lateral)
- Sempre visível
- Destaca a página atual
- Nome da escola no topo
- Botão **Sair** no rodapé

### Header (Topo)
- Título da página atual
- Data/hora atual

---

## 🔒 Segurança

- ✅ Cada usuário vê **APENAS** dados da sua escola
- ✅ Logout seguro com invalidação de sessão
- ✅ Proteção CSRF em formulários
- ✅ Middleware automático de verificação

---

## 💡 Dicas

### Período de Consulta
- Para ver dados de **hoje**, use:
  - Data início: `08/11/2025`
  - Data fim: `08/11/2025`

- Para ver dados da **última semana**, use:
  - Data início: `01/11/2025`
  - Data fim: `08/11/2025`

### Ordenação
- **Alfabética**: ordem A-Z por nome
- **Por Data**: ordem cronológica pela primeira movimentação

### AJAX Automático
- Ao selecionar uma turma no **"Movimentação por Aluno"**, os alunos carregam automaticamente
- Não precisa recarregar a página

---

## ❓ Problemas Comuns

### Servidor não inicia?
```bash
# Verifique se a porta 8000 está livre
php artisan serve --port=8001
```

### Não consigo fazer login?
- Verifique se usou o email correto: `escolaa@itag.com`
- Senha: `senha123` (tudo minúsculo)
- Se ainda não funcionar, execute:
```bash
php artisan db:seed --class=UsersSeeder
```

### Nenhum dado aparece nos relatórios?
- Verifique se o banco tem dados:
```bash
php artisan db:seed --class=CompleteDatabaseSeeder
```

---

## 🎉 Pronto!

Agora você tem acesso completo ao sistema de monitoramento iTAG Realtime!

Para mais detalhes técnicos, veja: **`SISTEMA_COMPLETO.md`**

---

**Bom uso! 🚀**


