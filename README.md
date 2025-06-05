````markdown
# 📝 Todo List API

API simples desenvolvida em **Laravel 12** para gerenciamento de tarefas (_To-Do List_). Permite criar, listar, atualizar e remover tarefas.

## ✅ Requisitos

- PHP >= 8.2  
- Composer  
- MySQL (ou outro banco de dados compatível)  
- Laravel CLI  

---

## ⚙️ Como configurar o projeto

1. **Clone o repositório:**

```bash
git clone https://github.com/ivandroJ/to_do_list.git
cd to_do_list
````

2. **Instale as dependências PHP:**

```bash
composer install
```

3. **Copie o arquivo `.env.example` para `.env`:**

```bash
cp .env.example .env
```

4. **Gere a chave da aplicação:**

```bash
php artisan key:generate
```

5. **Configure o banco de dados no arquivo `.env`:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_list_db
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

---

## 🗃️ Como rodar as migrations

Certifique-se de que o banco de dados está criado e acessível.

```bash
php artisan migrate
```

---

## 🚀 Como executar o servidor local

```bash
php artisan serve
```

O servidor será iniciado em:
📍 `http://localhost:8000`

---

## 🔍 Como testar a API

### Endpoints disponíveis

Acesse a documentação, com exemplos em:
`http://localhost:8000/api/documentation`


---

## 🧪 Testes automatizados (opcional)

```bash
php artisan test
```

---

## 📌 Notas

* Este projeto segue a estrutura padrão de APIs RESTful.
---

## 👨‍💻 Autor

Desenvolvido por \[Ivandro Culonguissa]

---








````markdown
# 📝 NEWS API CLIENT

## 🔐 Configuração da Chave de Acesso (API Key)

Para consumir a API de notícias, é necessário configurar uma chave de acesso (API Key). Siga os passos abaixo:

1. Registre-se ou autentique-se no site oficial da API de notícias [https://newsapi.org](https://newsapi.org).

2. Gere sua chave de acesso (API Key) no painel da conta.

3. Crie um arquivo `.env` na raiz do projeto e adicione a seguinte linha:

   ```env
   NEWS_API_KEY=sua_chave_aqui
   ```

---

## 📡 Endpoint Criado

A aplicação expõe o seguinte endpoint para consumir notícias da API:

```http
GET /api/news/top
```

### Parâmetros opcionais de query:

| Parâmetro  | Descrição                              | Exemplo             |
| ---------- | -------------------------------------- | ------------------- |
| `q`        | Palavra-chave para busca               | `q=tecnologia`      |
| `country`  | Código do país das notícias (ISO 3166) | `country=br`        |
| `category` | Categoria da notícia                   | `category=business` |

Exemplo completo de requisição:

```http
GET /api/news/top?q=tecnologia&country=br
```

---

## 🧾 Exemplo de Resposta

```json
{
  "status": "ok",
  "totalResults": 2,
  "articles": [
    {
      "source": {
        "id": null,
        "name": "G1"
      },
      "author": "João Silva",
      "title": "Nova tecnologia revoluciona o mercado de IA",
      "description": "Empresas apostam em inovação para se manterem competitivas.",
      "url": "https://g1.globo.com/tecnologia/noticia/...",
      "urlToImage": "https://g1.globo.com/tecnologia/imagem.jpg",
      "publishedAt": "2025-06-01T12:00:00Z",
      "content": "O setor de tecnologia está em constante evolução..."
    },
    {
      "source": {
        "id": null,
        "name": "Estadão"
      },
      "author": "Maria Oliveira",
      "title": "Startups brasileiras atraem investimentos em 2025",
      "description": "Crescimento do ecossistema de inovação no país.",
      "url": "https://estadao.com.br/economia/startups2025",
      "urlToImage": "https://estadao.com.br/img/startups.jpg",
      "publishedAt": "2025-06-01T09:30:00Z",
      "content": "O cenário para startups no Brasil continua favorável..."
    }
  ]
}
```
---

## 🧾 Exemplo Implementado

Com o servidor local iniciado, acesse:

`http://127.0.0.1:8000/news/top`

Como exemplo de implementação no front-end.

