<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Configurações do projeto

### .env

Após clonar o projeto, copiar o arquivo `.env.exemple` e renomear para `.env`

#### configurar as variaveis de ambiente
`FRONTEND_URL=` url do frontend para o cors
`FRONTEND_PEDIDO_DETALHES_URL="${FRONTEND_URL}/pedido/detalhes/"` variavel necessario para o envio do link de detalhes do pedido no email

#### configurar as variaveis de ambiente do banco
`DB_CONNECTION=pgsql`\
`DB_HOST=localhost`\
`DB_PORT=5432`\
`DB_DATABASE=`\
`DB_USERNAME=postgres`\
`DB_PASSWORD=`

Obs: O projeto foi desenvolvido para usar o banco de dados postgres, pode acontecer algum problema se usar outro banco de dados

#### configurar as variaveis de ambiente do serviço de email

No projeto usei o smtp do gmail, então vou deixar pre configurado. o MAIL_USERNAME é o email e o MAIL_PASSWORD é uma chave gerada nas configurações de segurança do gmail, para permitir que outros serviços usem seu email como remetente.

`MAIL_MAILER=smtp`\
`MAIL_HOST=smtp.gmail.com`\
`MAIL_PORT=587`\
`MAIL_USERNAME=`\
`MAIL_PASSWORD=`\
`MAIL_ENCRYPTION=null`\
`MAIL_FROM_ADDRESS=`\
`MAIL_FROM_NAME="${APP_NAME}"`

### Instação de dependencias

#### executar o comando para instalar as dependecias do composer
``` sh
composer install
```

#### executar o comando para instalar as dependecias do node_modules
``` sh
npm install
```

#### executar o comando para gerar a chave no .env
``` sh
php artisan key:generate
```

### Criando o banco

Crie o banco de dados com o nome que foi definido na configuração do .env

#### executar o comando para rodar as migrations
``` sh
php artisan migrate --seed
```

Obs: Será gerado uma seed para user com email `admin@admin.com` e senha `admin`

### Rodando o projeto

#### executar o comando para iniciar o server
``` sh
php artisan serve
```

#### executar o comando para rodar as compilações de css
``` sh
npm run dev
```

#### executar o comando para iniciar as Jobs
``` sh
php artisan queue:work
```



## Tecnlogias Usadas

`php versão 8.2`\
`laravel versão 11.9`\
`laravel sanctum versão 4.0`\
`livewire versão 3.4`\
`livewire toaster versão 2.3`\
`laravel breeze versão 2.2`\
`fakerphp versão 1.23`\
`postcss versão 8.4.31`\
`tailwindcss versão 3.1.0`\
`vite versão 5.0`\
`alpine mask versão 3.14.1`
