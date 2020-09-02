<p align="center">
    <img src="https://github.com/fsclaro/gennix/blob/master/_docs/logo_gennix.png?raw=true">
</p>

<p align="center">
    <img src="https://img.shields.io/github/issues/fsclaro/gennix" alt="Badge - Issues">
    <img src="https://img.shields.io/github/forks/fsclaro/gennix" alt="Badge - Forks">
    <img src="https://img.shields.io/github/stars/fsclaro/gennix" alt="Badge - Stars">
    <img src="https://img.shields.io/github/license/fsclaro/gennix" alt="Badge - License">
    <img src="https://img.shields.io/twitter/url?url=https://github.com/fsclaro/gennix" alt="Badge - Tweet This">
</p>

<hr>
<p align="center">
If you prefer english version, <a href="https://github.com/fsclaro/gennix/blob/master/README-en.md">click here</a>
</p>
<hr>

## Tabela de Conteúdos
- [Tabela de Conteúdos](#tabela-de-conteúdos)
- [Sobre este projeto](#sobre-este-projeto)
- [Ambiente mínimo](#ambiente-mínimo)
- [Pacotes incluídos no projeto](#pacotes-incluídos-no-projeto)
  - [Produção](#produção)
  - [Desenvolvimento](#desenvolvimento)
- [Clonando o projeto](#clonando-o-projeto)
- [Criando o arquivo de parâmetros/configuração do projeto](#criando-o-arquivo-de-parâmetrosconfiguração-do-projeto)
- [Preparando o banco de dados](#preparando-o-banco-de-dados)
  - [Configurando o banco de dados](#configurando-o-banco-de-dados)
- [Executando os comandos de instalação dos pacotes e configurações iniciais](#executando-os-comandos-de-instalação-dos-pacotes-e-configurações-iniciais)
- [Outras configurações](#outras-configurações)
  - [DEBUGBAR](#debugbar)
  - [USE_SOCIALITE](#use_socialite)
    - [SOCIALITE_FACEBOOK, SOCIALITE_TWITTER, SOCIALITE_GITHUB, SOCIALITE_LINKEDIN, SOCIALITE_GOOGLE](#socialite_facebook-socialite_twitter-socialite_github-socialite_linkedin-socialite_google)
  - [EXTERNAL_IP](#external_ip)
  - [FOOTER_CENTER, FOOTER_LEFT, FOOTER_RIGHT](#footer_center-footer_left-footer_right)
  - [FORMATAÇÃO DE DATA E HORA](#formatação-de-data-e-hora)
  - [MULTI_LANGUAGE](#multi_language)
- [Executando a aplicação](#executando-a-aplicação)
- [Comandos adicionados ao composer](#comandos-adicionados-ao-composer)
  - [*composer update**](#composer-update)
  - [*composer clear-all*](#composer-clear-all)
  - [*composer cache-all*](#composer-cache-all)
  - [*composer ide-helper*](#composer-ide-helper)
  - [*composer format*](#composer-format)
  - [*composer beautify*](#composer-beautify)
    - [Para instalação global](#para-instalação-global)
    - [Para instalação local](#para-instalação-local)
- [Internacionalização](#internacionalização)
- [CRUD](#crud)
- [Contribuições](#contribuições)
- [Código de Conduta](#código-de-conduta)
- [Vulnerabilidades e Segurança](#vulnerabilidades-e-segurança)
- [Licença](#licença)

<hr>

## Sobre este projeto

O projeto **gennix** tem a intenção de ser um ponto de partida para outros projetos baseados no framework Laravel. Este boilerplate contém uma série de pacotes que permitirá acelerar a construção dos seus projetos WEB.

## Ambiente mínimo

Para instalar e utilizar o **gennix** a configuração mínima exigida é:

* PHP: 7.2
* Laravel: 7.*

## Pacotes incluídos no projeto

Este projeto utiliza os seguintes pacotes de terceiros

### Produção

* arcanedev/log-viewer
* arcanedev/route-viewer
* arrilot/laravel-widgets
* beyondcode/laravel-self-diagnosis
* binarytorch/larecipe
* creativeorange/gravatar
* davejamesmiller/laravel-breadcrumbs
* jeroennoten/laravel-adminlte
* laravel/socialite
* yajra/laravel-datatables-oracle
* laravel/ui
* maatwebsite/excel
* realrashid/sweet-alert
* renatomarinho/laravel-page-speed
* spatie/laravel-activitylog
* spatie/laravel-backup
* spatie/laravel-medialibrary
* spatie/laravel-sluggable
* h4cc/wkhtmltoimage-amd64
* h4cc/wkhtmltopdf-amd64
* barryvdh/laravel-snappy

### Desenvolvimento

* arryvdh/laravel-debugbar
* barryvdh/laravel-ide-helper
* matt-allan/laravel-code-style
* squizlabs/php_codesniffer

## Clonando o projeto

Para utilizar e/ou testar este projeto, você deve digitar as seguintes linhas abaixo no seu terminal

```bash
git clone git@github.com:fsclaro/gennix.git
```

Após concluída a clonagem, você deve realizar a configuração inicial. Para isso siga os passos abaixo:

## Criando o arquivo de parâmetros/configuração do projeto

Estando no terminal e dentro da pasta do projeto, digite a linha abaixo para copiar o arquivo de exemplo de configuração do ambiente

```bash
cp .env.example .env
```

## Preparando o banco de dados

Você pode criar o banco de dados diretamente na linha de comando através da instrução abaixo.

```bash
mysql -e 'create database <YOUR_DATABASE_NAME>;' -u <YOUR_MYSQL_USERNAME> -p
```

Caso você prefira, utilize um programa gerenciador de banco de dados de sua escolha.

### Configurando o banco de dados

Edite o arquivo *.env* e modifique os parâmetros abaixo, conforme as informações que você utiliza para acessar o seu banco de dados

```bash
DB_DATABASE=<YOUR_DATABASE_NAME>
DB_USERNAME=<YOUR_MYSQL_USERNAME>
DB_PASSWORD=<PASSWORD_OF_YOUR_MYSQL_USERNAME>
```

Os valores iniciais destes parâmetros são:

```bash
DB_DATABASE=gennix
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## Executando os comandos de instalação dos pacotes e configurações iniciais

No terminal execute os seguintes comandos:

```bash
composer install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

## Outras configurações

No arquivo *.env* você encontrará outras configurações que podem ser realizadas. Estas estão descritas a seguir.

### DEBUGBAR

O parâmetro *DEBUGBAR_ENABLED* deve ser ativado ou desativado dependendo do ambiente onde você estiver executando o projeto. Para o ambiente de desenvolvimento você pode ativar este recurso, caso necessite realizar depurações durante o criação e testes do seu projeto.

Mas para o ambiente de produção, recomendo fortemente que você deixe desativado para que não ocorram problemas de performance do projeto.

Os valores permitidos para este parâmetro são: *true* ou *false*

### USE_SOCIALITE

Se você quiser liberar o acesso dos usuários do sistema através das redes sociais, você deve setar este parâmetro para *true*. Aos fazer isso, o *gennix* entenderá que deverá exibir na tela de login os botões das redes sociais para que os usuários possam se identificar desta forma.

Ativando este recurso, você deve obrigatóriamente escolher pelo menos uma das redes sociais disponíveis no **gennix**, descritas a seguir:

#### SOCIALITE_FACEBOOK, SOCIALITE_TWITTER, SOCIALITE_GITHUB, SOCIALITE_LINKEDIN, SOCIALITE_GOOGLE

Selecione quais redes sociais serão liberadas para que o usuário possa fazer o login no sistema. Os parâmetros que devem ser configuradas para cada uma delas são:

| Rede social | Ativação                | Parâmetros de acesso                        |
| ----------- | ----------------------- | ------------------------------------------- |
| Facebook    | SOCIALITE_FACEBOOK=true | FACEBOOK_CLIENT_ID e FACEBOOK_CLIENT_SECRET |
| Twitter     | SOCIALITE_TWITTER=true  | TWITTER_CLIENT_ID e TWITTER_CLIENT_SECRET   |
| GitHub      | SOCIALITE_GITHUB=true   | GITHUB_CLIENT_ID e GITHUB_CLIENT_SECRET     |
| LinkedIn    | SOCIALITE_LINKEDIN=true | LINKEDIN_CLIENT_ID e LINKEDIN_CLIENT_SECRET |
| Google      | SOCIALIE_GOOGLE=true    | GOOGLE_CLIENT_ID e GOOGLE_CLIENT_SECRET     |

Para definir os valores do CLIENT_ID e CLIENT_SECRET das suas redes sociais escolhidas, utilize os seguintes links:

* [Facebook](https://developers.facebook.com/apps/)
* [Twitter](https://developer.twitter.com/en/apps)
* [Github](https://github.com/settings/applications/new)
* [LinkedIn](https://www.linkedin.com/developers/)
* [Google](https://console.cloud.google.com)

Para configurar o acesso através de outras redes sociais, consulte maiores detalhes através deste [link](https://socialiteproviders.com/).

Para adicionar outras redes sociais, além de criar os parâmetros no arquivo *.env*, você também deve editar o arquivo */config/services.php* e adicionar as entradas equivalentes conforme o exemplo abaixo:

```php
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('APP_URL') . '/login/linkedin/callback',
    ],
```

Também deverá alterar o arquivo */resources/views/vendor/adminlte/auth/login.blade.php* para adicionar o código necessário para que sistema entenda que você está liberando o acesso por uma nova rede social.

Localize no código o trecho onde são tratados os links para acesso pela rede social e acrescente o código como o exemplo abaixo, fazendo-se as adaptações necessárias:

```php
    if(env('SOCIALITE_GOOGLE'))
    <a href="{{ route('login.social', 'google') }}"
        class="btn google-color rounded-circle mx-1">
        <i class="fab fa-google"></i>
    </a>
    endif
```

>**IMPORTANTE**: A utilização do recurso de login através de redes sociais implementadas no projeto, é única e exclusivamente para realizar a autenticação de acesso. Não foi implementado no projeto a possibilidade de cadastrar novos usuários através das redes sociais. Muito embora seja um recurso que você facilmente implementaria no projeto.


### EXTERNAL_IP

Um dos recursos previstos no *gennix* é o registro do IP do usuário que está acessando a aplicação. Para isso, são utilizados os serviços do provedor IPIFY. Caso queira alterar o provedor que irá identificar o IP do seu cliente, basta definir a url do mesmo neste parâmetro.

>Valor padrão:<br>
EXTERNAL_IP=https://api.ipify.org


### FOOTER_CENTER, FOOTER_LEFT, FOOTER_RIGHT

Estes parâmetros permitem que você personalize o rodapé da aplicação. Para isso, você tem duas opções:

**a) Rodapé centralizado**

Para ter um texto que ficará centralizado no rodapé da página, basta você definir o conteúdo no parâmetro *FOOTER_CENTER*.

**b) Rodapé do lado esquerdo e lado direito**

A outra opção será você definir o texto que deseja tanto do lado esquerdo quando do lado direito nos parâmetros *FOOTER_LEFT* e *FOOTER_RIGHT* respectivamente.

Caso você defina valores para os três parâmetros, o *FOOTER_CENTER* terá prioridade, ignorando os parâmetros *FOOTER_LEFT* e *FOOTER_RIGHT*.

Estes parâmetros aceitam tags HTML para que você possa utilizar a sua criatividade para construir o rodapé da forma mais adequada para a sua aplicação.

### FORMATAÇÃO DE DATA E HORA

Os parâmetros abaixo, permitem que você defina o formato da data e da hora que serão utilizadas na aplicação.

**a) DATE_FORMAT** - Data no formato dd/mm/aa. Exemplo: 10/05/20<br>
**b) DATE_FORMAT_LONG** - Data no formato dd/mm/aaaa. Exemplo: 15/08/2020<br>
**c) DATE_FORMAT_LONG_LONG** - Data no formato dia-da-semana, dd de mês-por-extenso de aaaa. Exemplo: Quinta Feira, 10 de Março de 2020<br>
**d) TIME_FORMAT** - Hora no formato hh:mm. Exemplo: 10:15<br>
**e) TIME_FORMAT_LONG** - Hora no formato hh:mm:ss. Exemplo: 21:47:31

Neste [link](https://www.php.net/manual/pt_BR/function.date.php) você encontrará como pode personalizar a data e a hora para outros formatos desejados.

### MULTI_LANGUAGE
Este parâmetro permite que o sistema exiba os recursos onde o usuário poderá escolher em qual linguagem o sistema será exibido.

Os valores possíveis são **true** ou **false**. Quando o valor estiver como **true** o sistema exibirá na tela de login e também no menu superior do dashboard do sistema os flags das linguagens disponíveis. Sendo que a linguagem default do sistema é **pt-BR**. Atualmente os valores possíveis são **pt-BR** e **en**.


>Valor Padrão: **true**

## Executando a aplicação

Considerando que você já configurou sem ambiente apache ou nginx para apontar para a sua aplicação, agora você pode testar o projeto. Para isso, utilize um dos usuários abaixo para se identificar na tela de login

| Nome do Usuário  | Papel      | Login                  | Senha    |
| ---------------- | ---------- | ---------------------- | -------- |
| **Super Admin**  | Superadmin | superadmin@gennix.test | superman |
| **Peter Markus** | Admin      | peter@gennix.test      | 12345678 |
| **Jane Garcez**  | User       | jane@gennix.test       | 12345678 |


## Comandos adicionados ao composer

O *gennix* possui alguns comandos complementares ao composer. Estes comandos complementares podem ser enconstrados no arquivo *_composer.json_*.

Abaixo, descrevo os novos comandos e o que cada um deles fazem.

### *composer update**
Após a atualização e/ou instalação dos pacotes, será executado o comando *clear-all* descrito a seguir.

### *composer clear-all*

* artisan clear-compiled
* artisan cache:clear
* artisan route:clear
* artisan view:clear
* artisan config:clear
* composer dumpautoload -o

### *composer cache-all*

* artisan config:cache
* artisan route:cache

### *composer ide-helper*

* artisan ide-helper:generate
* artisan ide-helper:meta

### *composer format*

* php-cs-fixer fix app/ --show-progress=estimating
* php-cs-fixer fix config/ --show-progress=estimating
* php-cs-fixer fix database/ --show-progress=estimating
* php-cs-fixer fix resources/ --show-progress=estimating
* php-cs-fixer fix routes/ --show-progress=estimating
* php-cs-fixer fix tests/ --show-progress=estimating

### *composer beautify*

* phpcbf --standard=PSR2 -p app/*
* phpcbf --standard=PSR2 -p database/*
* phpcbf --standard=PSR2 -p resources/*

>OBS: os comandos *_format_* e *_beautify_* necessitam do pacote php-cs-fixer instalado de forma global ou local no seu ambiente. Caso você não tenha este pacote instalado, execute um dos comandos abaixo, conforme sua necessidade,  para fazer a instalação.



#### Para instalação global

```bash
composer global require friendsofphp/php-cs-fixer
```

#### Para instalação local

```bash
composer require friendsofphp/php-cs-fixer --dev
```


## Internacionalização

O projeto *gennix* está inicialmente configurado para o Português do Brasil. Os parâmetros que definem a língua com a qual o ambiente utilizará estão definidas no arquivo */config/app.php*. Sendo que os parâmetros principais são:

**a) timezone** - America/Sao_Paulo<br>
**b) locale** - pt-BR

Caso você queira utilizar o sistema em uma língua diferente do Português Brasileiro ou do Inglês, você poderá traduzir os arquivos que contém todas as mensagens exibidas no sistema. Abaixo descrevo os locais onde este arquivos estão localizado e para o que os mesmos são utilizados.

* /resources/lang/pt-BR/gennix.php - contém as mensagens específicas do sistema
* /resources/lang/vendor/adminlte - contém os arquivos de mensagens do adminlte


## CRUD

Este projeto dispõe de um recurso de criação da CRUD básica que permitirá acelerar o desenvolvimento do projeto.

Este recurso é obtido através da execução do seguinte comando:

```bash
php artisan gennix:crud <options> <name>
```

Onde:
* **name** - é o nome da classe do CRUD que deseja criar.
>IMPORTANTE: O nome da classe deve estar no singular sendo que a primeira letra em Maiúscula. Maiores detalhes você pode ver [aqui](https://github.com/php-fig/fig-standards).

* **options** - pode ser:

| Chave         | O que é criado                              | Local onde os arquivos serão criados |
| ------------- | ------------------------------------------- | ------------------------------------ |
| --controller  | Controller                                  | /app/Http/Controller                 |
| --model       | Model                                       | /app                                 |
| --request     | Requests (update e store)                   | /app/Http/Requests                   |
| --views       | Views (index, create, edit, show)           | /resources/views/admin               |
| --breadcrumbs | Breadcrumbs para todas as operações do CRUD | /routes                              |
| --routes      | Rota do tipo resources                      | /routes                              |
| --migrations  | Migration da classe                         | /database/migrations                 |
| --permissions |
| --all         | Todos os recursos acima descritos           | ---                                  |

*Exemplo:*

```bash
php artisan gennix:crud --all Estoque
```

Caso você necessite personalizar as templates que são utilizadas para a geração dos arquivos criados, basta editar os *stubs* que estão localizados em */resources/views/stubs*.

Depois que você criou o novo CRUD, não se esqueça de editar o arquivo *config/adminlte.php* e na seção *menu* adicionar e/ou alterar os parâmetros para que o novo CRUD apareça no menu do sistema. Localize o trecho abaixo e faça os ajustes necessários.

```php
// [
//     'text'  => 'audit',
//     'icon'  => 'fa fa-fw fa-binoculars',
//     'route' => 'audit.index',
//     'can'   => 'audit-access'
// ],
```

Também, se for o caso, crie as permissões e papéis necessários para o novo CRUD.


## Contribuições

Caso você tenha interesse em colaborar com as melhorias do projeto *gennix* com boas ideias ou informando _bugs_ ou qualquer outro tipo de problema, por favor leia o [guia de contribuições](https://github.com/fsclaro/gennix/blob/master/CONTRIBUTING.md) (em inglês) e registre uma PR (pull request) ou uma Issue.

## Código de Conduta

É muito importante que você leia o [código de conduta](https://github.com/fsclaro/gennix/blob/master/CODE_OF_CONDUCT.md) (em inglês) para que exista uma coexistência pacífica entre os membros participantes deste projeto.

## Vulnerabilidades e Segurança

Se você descobrir alguma vulnerabilidade de segurança neste projeto, por favor, envie um email para [Nando Salles](mailto:fsclaro@gmail.com).

## Licença

Este projeto é licenciado sobre as normas do [MIT license](https://github.com/fsclaro/gennix/blob/master/LICENSE.md) (em inglês).
