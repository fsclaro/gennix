<p align="center">
<img src="https://github.com/fsclaro/gennix/blob/master/_docs/img/logo_gennix.png?raw=true">
</p>


https://img.shields.io/github/issues/fsclaro/gennix 
https://img.shields.io/github/forks/fsclaro/gennix
https://img.shields.io/github/stars/fsclaro/gennix
https://img.shields.io/github/license/fsclaro/gennix
https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2Ffsclaro%2Fgennix

## 1) Sobre este projeto

O projeto **gennix** tem a intenção de ser um ponto de partida para outros projetos baseados no framework Laravel. Este boilerplate contém uma série de pacotes que permitirá acelerar a construção dos seus projetos WEB.

## 2) Ambiente mínimo
Para instalar e utilizar o **gennix** a configuração mínima exigida é:

- Versão mínima do PHP: 7.2
- Versão mínima do Laravel: 7.*
- Timezone: America/Sao_Paulo
- Locale: pt-BR
- Banco de Dados: MySQL/MariaDB

## 3) Pacotes incluídos do projeto
Este projeto utiliza os seguintes pacotes de terceiros

- arcanedev/log-viewer
- arcanedev/route-viewer
- arrilot/laravel-widgets
- creativeorange/gravatar
- davejamesmiller/laravel-breadcrumbs
- jeroennoten/laravel-adminlte
- laravel/socialite
- yajra/laravel-datatables-oracle
- laravel/ui
- realrashid/sweet-alert
- spatie/laravel-medialibrary
- spatie/laravel-sluggable

## 4) Pacotes incluídos no ambiente de desenvolvimento
Para o ambiente de desenvolvimento, além dos descritos acima, o projeto utiliza os seguintes pacotes:

- arryvdh/laravel-debugbar
- barryvdh/laravel-ide-helper
- matt-allan/laravel-code-style

## 5) Clonando o projeto
Para utilizar e/ou testar este projeto, você deve digitar as seguintes linhas abaixo no seu terminal
```bash
git clone git@github.com:fsclaro/gennix.git
```

Após concluída a clonagem, você deve realizar a configuração inicial. Para isso siga os passos abaixo:

### 5.1) Criando o arquivo de parâmetros/configuração do projeto
Estando no terminal e dentro da pasta do projeto, digite a linha abaixo para copiar o arquivo de exemplo de configuração do ambiente
```bash
cp .env.example .env
```

### 5.2) Crie o banco de dados do projeto
Você pode criar o banco de dados diretamente na linha de comando através da instrução abaixo.
```bash
mysql -e 'create database <YOUR_DATABASE_NAME>;' -u <YOUR_MYSQL_USERNAME> -p
```
Caso você prefira, utilize um programa gerenciador de banco de dados de sua escolha.

### 5.3) Configurando o banco de dados

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

### 5.4) Executando os comandos de instalação dos pacotes e configurações iniciais
No terminal execute os seguintes comandos:
```bash
composer install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

## 6) Outras configurações que podem/devem ser realizadas
No arquivo *.env* você encontrará outras configurações que podem ser realizadas. Estas estão descritas a seguir.

### 6.1) DEBUGBAR
O parâmetro *DEBUGBAR_ENABLED* deve ser ativado ou desativado dependendo do ambiente onde você estiver executando o projeto. Para o ambiente de desenvolvimento você pode ativar este recurso, caso necessite realizar depurações durante o criação e testes do seu projeto.

Mas para o ambiente de produção, recomendo fortemente que você deixe desativado para que não ocorram problemas de performance do projeto.

Os valores permitidos para este parâmetro são: *true* ou *false*

### 6.2) USE_SOCIALITE
Se você quiser liberar o acesso dos usuários do sistema através das redes sociais, você deve setar este parâmetro para *true*. Aos fazer isso, o *gennix* entenderá que deverá exibir na tela de login os botões das redes sociais para que os usuários possam se identificar desta forma.

Ativando este recurso, você deve obrigatóriamente escolher pelo menos uma das redes sociais disponíveis no **gennix**, descritas a seguir:

#### 6.2.1) SOCIALITE_FACEBOOK, SOCIALITE_TWITTER, SOCIALITE_GITHUB, SOCIALITE_LINKEDIN, SOCIALITE_GOOGLE

Selecione quais redes sociais serão liberadas para que o usuário possa fazer o login no sistema. Os parâmetros que devem ser configuradas para cada uma delas são:

| Rede social | Ativação                | Parâmetros de acesso                        |
|-------------|-------------------------|---------------------------------------------|
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
    @if(env('SOCIALITE_GOOGLE'))
    <a href="{{ route('login.social', 'google') }}"
        class="btn google-color rounded-circle mx-1">
        <i class="fab fa-google"></i>
    </a>
    @endif
```

**IMPORTANTE**: A utilização do recurso de login através de redes sociais implementadas no projeto, é única e exclusivamente para realizar a autenticação de acesso. Não foi implementado no projeto a possibilidade de cadastrar novos usuários através das redes sociais. Muito embora seja um recurso que você facilmente implementaria no projeto.


### 6.3) EXTERNAL_IP
Um dos recursos previstos no *gennix* é o registro do IP do usuário que está acessando a aplicação. Para isso, é utilizado os serviços do provedor IPIFY. Caso queira alterar o provedor que irá identificar o IP do seu cliente, basta definir a url do mesmo neste parâmetro.

Valor padrão:
EXTERNAL_IP=https://api.ipify.org


### 6.4) FOOTER_CENTER, FOOTER_LEFT, FOOTER_RIGHT
Estes parâmetros permitem que você personalize o rodapé da aplicação. Para isso, você tem duas opções:

**a) Rodapé centralizado**
Para ter um texto que ficará centralizado no rodapé da página, basta você definir o conteúdo no parâmetro *FOOTER_CENTER*.

**b) Rodapé do lado esquerdo e lado direito**
A outra opção será você definir o texto que deseja tanto do lado esquerdo quando do lado direito nos parâmetros *FOOTER_LEFT* e *FOOTER_RIGHT* respectivamente.

Caso você defina valores para os três parâmetros, o *FOOTER_CENTER* terá prioridade, ignorando os parâmetros *FOOTER_LEFT* e *FOOTER_RIGHT*.

Estes parâmetros aceitam tags HTML para que você possa utilizar a sua criatividade para construir o rodapé da forma mais adequada para a sua aplicação.

### 6.5) FORMATAÇÃO DE DATA E HORA
Os parâmetros abaixo, permitem que você defina o formato da data e da hora que serão utilizadas na aplicação.

**a) DATE_FORMAT** - Data no formato dd/mm/aa. Exemplo: 10/05/20
**b) DATE_FORMAT_LONG** - Data no formato dd/mm/aaaa. Exemplo: 15/08/2020
**c) DATE_FORMAT_LONG_LONG** - Data no formato dia-da-semana, dd de mês-por-extenso de aaaa. Exemplo: Quinta Feira, 10 de Março de 2020
**d) TIME_FORMAT** - Hora no formato hh:mm. Exemplo: 10:15
**e) TIME_FORMAT_LONG** - Hora no formato hh:mm:ss. Exemplo: 21:47:31

Neste [link](https://www.php.net/manual/pt_BR/function.date.php) você encontrará como pode personalizar a data e a hora para outros formatos desejados.

## 7) Executando a aplicação
Considerando que você já configurou sem ambiente apache ou nginx para apontar para a sua aplicação, agora você pode testar o projeto. Para isso, utilize um dos usuários abaixo para se identificar na tela de login

| Nome do Usuário    | Papel      | Login                  | Senha    |
|--------------------|------------|------------------------|----------|
| **Super Admin**    | Superadmin | superadmin@gennix.test | superman |
| **Peter Markus**   | Admin      | peter@gennix.test      | 12345678 |
| **Jane Garcez**    | User       | jane@gennix.test       | 12345678 |


## 8) Comandos adicionados ao composer

### 8.1) *composer clear-all*, executará a seguinte sequência:
* artisan clear-compiled
* artisan cache:clear
* artisan route:clear
* artisan view:clear
* artisan config:clear
* composer dumpautoload -o

### 8.2) *composer cache-all*, executará a seguinte sequência:
* artisan config:cache
* artisan route:cache

### 8.3) *composer ide-helper*, executará a seguinte sequência:
* artisan ide-helper:generate
* artisan ide-helper:meta

### 8.4) *composer format*, executará a seguinte sequência:
* php-cs-fixer fix app/ --show-progress=estimating
* php-cs-fixer fix config/ --show-progress=estimating
* php-cs-fixer fix database/ --show-progress=estimating
* php-cs-fixer fix resources/ --show-progress=estimating
* php-cs-fixer fix routes/ --show-progress=estimating
* php-cs-fixer fix tests/ --show-progress=estimating

*_OBS_*: este comando necessita do pacote php-cs-fixer instalado ou de forma global ou local no seu ambiente. Caso você tenha este pacote instalado, execute o comando abaixo para fazer a instalação.

```bash
composer global require friendsofphp/php-cs-fixer
```

## 9) Internacionalização

O projeto *gennix* está inicialmente configurado para o Português do Brasil. Os parâmetros que definem a língua com a qual o ambiente utilizará estão definidas no arquivo */config/app.php*. Sendo que os parâmetros principais são:

**a) timezone** - America/Sao_Paulo
**b) locale** - pt-BR

Caso você queira utilizar o sistema em uma língua diferente do Português Brasileiro ou do Inglês, você poderá traduzir os arquivos que contém todas as mensagens exibidas no sistema. Abaixo descrevo os locais onde este arquivos estão localizado e para o que os mesmos são utilizados.

* /resources/lang/pt-BR/gennix.php - contém as mensagens específicas do sistema
* /resources/lang/vendor/adminlte - contém os arquivos de mensagens do adminlte





## 10) CRUD
Este projeto dispõe de um recurso de criação da CRUD básica que permitirá acelerar o desenvolvimento do projeto.

Este recurso é obtido através da execução do seguinte comando:

```bash
php artisan gennix:crud [options] <name>
```

Onde:
* **name** - é o nome da classe do CRUD que deseja criar. *IMPORTANTE*: O nome da classe deve estar no singular.

* **options** - pode ser:

| Chave         | Descrição                                               | Local onde os arquivos serão criados |
|---------------|---------------------------------------------------------|--------------------------------------|
| --controller  | Criação do controller                                   | /app/Http/Controller                 |
| --model       | Criação do model                                        | /app                                 |
| --request     | Criação das requests (update e store)                   | /app/Http/Requests                   |
| --views       | Criação das views (index, create, edit, show)           | /resources/views/admin               |
| --breadcrumbs | Criação das breadcrumbs para todas as operações do CRUD | /routes                              |
| --routes      | Criação da rota do tipo resources                       | /routes                              |
| --migrations  | Criação da migration da classe                          | /database/migrations                 |
| --all         | Cria todos os recursos acima descritos                  | ---                                  |

*Exemplo:*

```bash
php artisan gennix:crud --all Estoque
```

Caso você necessite personalizar as templates que são utilizadas para a geração dos arquivos criados, basta editar os *stubs* que estão localizados em */resources/views/stubs*.


## 11) Contribuições

Caso você tenha interesse em colaborar com as melhorias do projeto *gennix* com boas ideias ou informando _bugs_ ou qualque outro tipo de problema, por favor leia o [guia de contribuições](https://github.com/fsclaro/gennix/blob/master/_docs/CONTRIBUTING.md) (em inglês) e envie um email para [fsclaro@gmail.com](mailto:fsclaro@gmail.com)

## 12) Código de Conduta

É muito importante que você leia o [código de conduta](https://github.com/fsclaro/gennix/blob/master/_docs/CODE_OF_CONDUCT.md) (em inglês) para que exista uma coexistência pacífica entre os membros participantes deste projeto.

## 13) Vulnerabilidades e Segurança

Se você descobrir alguma vunerabilidade de segurança neste projeto, por favor, envie um email para [Nando Salles](mailto:fsclaro@gmail.com).

## 14) Licença

Este projeto é licenciado sobre as normas do [MIT license](https://github.com/fsclaro/gennix/blob/master/_docs/LICENSE.md) (em inglês).
