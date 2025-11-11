# Crud‑Vue‑Laravel

## Stacks usadas

- Backend: Laravel (PHP)  
- Frontend: Vue.js  

## Como instalar / executar

### Pré‑requisitos

- PHP (versão compatível com Laravel)  
- Composer  
- Node.js e npm ou yarn  
- Banco de dados (MySQL, SQLite ou outro compatível com Laravel)  

### Passos

```bash
# 1. Clone este repositório
git clone https://github.com/VieiraPedroN/Crud-Vue-Laravel.git

# 2. Acesse a pasta Backend
cd Crud-Vue-Laravel/Backend

# 3. Instale o Laravel
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
## ou se ja tiver o php e o composer
composer global require laravel/installer 

# 4. Configure o arquivo .env (tem um exemplo dele)

# 5. Execute as migrations
php artisan migrate

# 6. Inicie o servidor do Laravel
php artisan serve
# Geralmente roda em http://127.0.0.1:8000
```

Em outro terminal:

```bash
# 7. Vá para a pasta Frontend
cd ../Frontend

# 8. Instale o node e as dependências do Vue
## link do node: https://nodejs.org/pt/download

npm install
# ou
yarn install

# 9. Inicie o servidor de desenvolvimento do Vue
npm run serve
# ou
yarn serve
# Acesse em http://localhost:8080

