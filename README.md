# CRUD Laravel - Gestao de Veiculos

Aplicacao Laravel para cadastro e gerenciamento de veiculos com area publica e painel administrativo. Este guia resume a arquitetura, o setup via Docker e as operacoes comuns.

## Visao geral

- Laravel 12 (PHP 8.2) com MySQL 8.0 e Vite/Node para assets.
- Interface publica lista veiculos com filtros por marca, modelo, cor e preco.
- Painel admin oferece CRUD completo para marcas, modelos, cores e veiculos.
- Seeds criam dados de exemplo e um usuario administrador pronto para uso.
- Cache reduz acessos repetidos ao banco, acelerando login e dashboard.

## Requisitos

- Docker Desktop (ou Docker Engine) 24+
- Docker Compose v2+

## Primeiros passos

1. Duplique o arquivo de variaveis (caso ainda nao exista):

   ```bash
   cp .env.example .env
   ```

2. Ajuste valores conforme necessario. Para o ambiente Docker, os principais valores ja sao injetados via `docker-compose.yml`, mas confirme:

   ```dotenv
   APP_URL=http://localhost:8000
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=laravel
   DB_PASSWORD=laravel
   ```

3. Instale as dependencias PHP (Composer):

   ```bash
   docker compose run --rm app composer install
   ```

4. Instale as dependencias do front-end (Node):

   ```bash
   docker compose run --rm node install
   ```

5. Gere a chave da aplicacao (necessario apenas uma vez):

   ```bash
   docker compose run --rm app php artisan key:generate
   ```

## Subindo os servicos

```bash
docker compose up -d
```

Depois da inicializacao:

- Rode as migracoes e seeds de demo:

  ```bash
  docker compose exec app php artisan migrate --seed
  ```

- Acesse a aplicacao em `http://localhost:8000`.

## Login administrativo

Credenciais padrao criadas pelo seeder (`database/seeders/DatabaseSeeder.php`):

- Email: `admin@autohub.com`
- Senha: `senha-segura`

Edite o seed ou altere a senha pelo painel apos o primeiro acesso, se desejar.

## Vite e assets

- Para rodar o modo de desenvolvimento do Vite com hot reload:

  ```bash
  docker compose run --rm --service-ports node run dev
  ```

- Para gerar os assets de producao:

  ```bash
  docker compose run --rm node run build
  ```

## Comandos uteis

- Abrir um shell dentro do container PHP:

  ```bash
  docker compose exec app bash
  ```

- Rodar testes:

  ```bash
  docker compose exec app php artisan test
  ```

- Limpar caches do Laravel (apos ajustes em config, rotas ou views):

  ```bash
  docker compose exec app php artisan cache:clear
  docker compose exec app php artisan config:clear
  ```

- Desligar e remover os containers:

  ```bash
  docker compose down
  ```

## Estrutura Docker

- `app`: PHP 8.2 com Composer e Artisan. Expoe a porta `8000`.
- `mysql`: MySQL 8.0 com volume nomeado `mysql_data`; porta host `3307` mapeia para `3306` no container.
- `node`: Node 20 para scripts Vite (perfil `frontend`).

Os volumes mapeiam o diretorio do projeto para facilitar o desenvolvimento local.

## Caching e performance

- Listas de marcas, modelos e cores ficam em cache (`brands.options`, `models.options`, `colors.options`) por 10 minutos e sao invalidadas sempre que algo muda via painel.
- O dashboard usa cache de 5 minutos (`dashboard.metrics`) para os contadores e ultimos veiculos.
- Esses caches reduzem consultas duplicadas e deixam a autenticacao e o admin mais rapidos.

Em producao considere executar:

```bash
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

## Estrutura principal

- `app/Http/Controllers/PublicVehicleController.php`: listagem e detalhes dos veiculos publicos (usa caches compartilhados).
- `app/Http/Controllers/Admin/*`: controllers do painel com invalidacao de cache e CRUD completo.
- `database/migrations`: tabelas de marcas, modelos, cores, veiculos e fotos.
- `database/seeders/DatabaseSeeder.php`: popula dados demo e cria o admin.
- `resources/views`: blades do site publico (`public/`), auth (`auth/`) e painel (`admin/`).
- `docker-compose.yml` / `Dockerfile`: definem o ambiente containerizado.

## Resolucao de problemas

- **Porta 3306 em uso no host**: ajuste `docker-compose.yml` para outra porta, exemplo `3308:3306`.
- **Aplicacao nao conecta no banco**: valide as variaveis `DB_*` dentro do container (`docker compose exec app cat .env`) e execute `php artisan config:clear`.
- **Tela de login/dash lenta**: limpe caches (`php artisan cache:clear`) e confirme recursos de CPU/RAM disponiveis para Docker.

## Licenca

Projeto para uso interno/educativo. Adapte conforme as necessidades da sua organizacao.
