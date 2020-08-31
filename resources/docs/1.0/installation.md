- [Instalando o projeto](#section-01)
- [Criando o banco de dados](#section-02)
- [Criando as tabelas](#section-03)
- [Populando as tabelas](#section-04)
- [Personalizando o projeto](#section-05)
- [Executando a aplicação](#section-06)

<a name="section-01"></a>
# Instalando o projeto

Para utilizar e/ou testar este projeto, você deve digitar a seguinte linha no seu terminal.

```bash
git clone git@github.com:fsclaro/gennix.git
```

---
Após concluída a clonagem, entre no diretório do projeto e execute os seguintes comandos:

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan storage:link
```

---
<a name="section-02"></a>
## Criando o banco de dados

Você pode criar o banco de dados diretamente na linha de comando através da instrução abaixo.

```bash
mysql -e 'create database <YOUR_DATABASE_NAME>;' -u <YOUR_MYSQL_USERNAME> -p
```

---
Caso você prefira, utilize um programa gerenciador de banco de dados de sua escolha.

---

Com o banco de dados criado, agora edite o arquivo **.env** e modifique os parâmetros abaixo, conforme as informações que você utiliza para acessar o seu banco de dados

```php
DB_DATABASE=<YOUR_DATABASE_NAME>
DB_USERNAME=<YOUR_MYSQL_USERNAME>
DB_PASSWORD=<PASSWORD_OF_YOUR_MYSQL_USERNAME>
```

---
Os valores iniciais destes parâmetros são:

```php
DB_DATABASE=gennix
DB_USERNAME=homestead
DB_PASSWORD=secret
```

---

<a name="section-03"></a>
## Criando as tabelas

No terminal, execute o comando abaixo para criar as tabelas e os registros iniciais.

```bash
php artisan migrate
```


<a name="section-04"></a>
## Populando as tabelas

Para iniciar as tabelas com os usuários iniciais, os papéis e as permissiões, execute o comando abaixo no terminal.

```bash
php artisan db:seed
````


<a name="section-05"></a>
## Personalizando o projeto

Existem vários parâmetros que podem ser configurados para que o sistema atenda melhor as necessidades de cada projeto.
Nesta seção você encontrará as informações necessárias para personalizar o projeto de forma que atenda melhor para cada
situação.

---
Estas personalizações são realizadas dentro do arquivo **.env**. Veja abaixo os detalhes de cada uma delas.

### 1. DEBUGBAR

O parâmetro *DEBUGBAR_ENABLED* deve ser ativado ou desativado dependendo do ambiente onde você estiver executando o
projeto. Para o ambiente de desenvolvimento você pode ativar este recurso, caso necessite realizar depurações durante
o criação e testes do seu projeto.

---

Mas para o ambiente de produção, recomendo fortemente que você deixe desativado para que não ocorram problemas de performance do projeto.

---

Os valores permitidos para este parâmetro são: *true* ou *false*

> {success} Valor padrão: **true**

### 2. USE_SOCIALITE

Se você quiser liberar o acesso dos usuários do sistema através das redes sociais, você deve setar este parâmetro para *true*. Aos fazer isso, o **gennix** entenderá que deverá exibir na tela de login os botões das redes sociais para que os usuários possam se identificar desta forma.

---

Ativando este recurso, você deve obrigatóriamente escolher pelo menos uma das redes sociais disponíveis no **gennix**, descritas a seguir:

---

Selecione quais redes sociais serão liberadas para que o usuário possa fazer o login no sistema. Os parâmetros que devem ser configuradas para cada uma delas são:

| Rede Social | Ativação                | Parâmetros de acesso                        |
| ----------- | ----------------------- | ------------------------------------------- |
| Facebook    | SOCIALITE_FACEBOOK=true | FACEBOOK_CLIENT_ID e FACEBOOK_CLIENT_SECRET |
| Twitter     | SOCIALITE_TWITTER=true  | TWITTER_CLIENT_ID e TWITTER_CLIENT_SECRET   |
| GitHub      | SOCIALITE_GITHUB=true   | GITHUB_CLIENT_ID e GITHUB_CLIENT_SECRET     |
| LinkedIn    | SOCIALITE_LINKEDIN=true | LINKEDIN_CLIENT_ID e LINKEDIN_CLIENT_SECRET |
| Google      | SOCIALITE_GOOGLE=true   | GOOGLE_CLIENT_ID e GOOGLE_CLIENT_SECRET     |

---

Para definir os valores do CLIENT_ID e CLIENT_SECRET das suas redes sociais escolhidas, utilize os seguintes links:

* [Facebook](https://developers.facebook.com/apps/)
* [Twitter](https://developer.twitter.com/en/apps)
* [Github](https://github.com/settings/applications/new)
* [LinkedIn](https://www.linkedin.com/developers/)
* [Google](https://console.cloud.google.com)

---

Para configurar o acesso através de outras redes sociais, consulte maiores detalhes através deste [link](https://socialiteproviders.com/).

---
Para adicionar outras redes sociais, além de criar os parâmetros no arquivo *.env*, você também deve editar o arquivo */config/services.php* e adicionar as entradas equivalentes conforme o exemplo abaixo:

```php
'linkedin' => [
    'client_id' => env('LINKEDIN_CLIENT_ID'),
    'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
    'redirect' => env('APP_URL') . '/login/linkedin/callback',
]
```

---
Também deverá alterar o arquivo */resources/views/vendor/adminlte/auth/login.blade.php* para adicionar o código necessário para que sistema entenda que você está liberando o acesso por uma nova rede social.

---

Localize no código o trecho onde são tratados os links para acesso pela rede social e acrescente o código como o exemplo abaixo, fazendo-se as adaptações necessárias:

```php
@if(env('SOCIALITE_GOOGLE'))
    <a href="{{ route('login.social', 'google') }}" class="btn google-color rounded-circle mx-1">
        <i class="fab fa-google"></i>
    </a>
@endif
```

> {info} **IMPORTANTE**: A utilização do recurso de login através de redes sociais implementadas no projeto, é única e exclusivamente para realizar a autenticação de acesso. Não foi implementado a possibilidade de cadastrar novos usuários através das redes sociais. Muito embora seja um recurso que você facilmente implementaria no projeto.


### 3. EXTERNAL_IP

Um dos recursos previstos no **gennix** é o registro do IP do usuário que está acessando a aplicação. Para isso, são utilizados os serviços do provedor IPIFY. Caso queira alterar o provedor que irá identificar o IP do seu cliente, basta definir a url do mesmo neste parâmetro.

> {success} Valor padrão: https://api.ipify.org


### 4. FOOTER_CENTER, FOOTER_LEFT, FOOTER_RIGHT

Estes parâmetros permitem que você personalize o rodapé da aplicação. Para isso, você tem duas opções:

---
**a) Rodapé centralizado**

Para ter um texto que ficará centralizado no rodapé da página, basta você definir o conteúdo no parâmetro *FOOTER_CENTER*.

---
**b) Rodapé do lado esquerdo e lado direito**

A outra opção será você definir o texto que deseja tanto do lado esquerdo quando do lado direito nos parâmetros *FOOTER_LEFT* e *FOOTER_RIGHT* respectivamente.

---
Caso você defina valores para os três parâmetros, o *FOOTER_CENTER* terá prioridade, ignorando os parâmetros *FOOTER_LEFT* e *FOOTER_RIGHT*.

---
Estes parâmetros aceitam tags HTML para que você possa utilizar a sua criatividade para construir o rodapé da forma mais adequada para a sua aplicação.

### 5. FORMATAÇÃO DE DATA E HORA

Os parâmetros abaixo, permitem que você defina o formato da data e da hora que serão utilizadas na aplicação.

---
**a) DATE_FORMAT** - Data no formato dd/mm/aa. Exemplo: 10/05/20<br>

---
**b) DATE_FORMAT_LONG** - Data no formato dd/mm/aaaa. Exemplo: 15/08/2020<br>

---
**c) DATE_FORMAT_LONG_LONG** - Data no formato dia-da-semana, dd de mês-por-extenso de aaaa. Exemplo: Quinta Feira, 10 de Março de 2020<br>

---
**d) TIME_FORMAT** - Hora no formato hh:mm. Exemplo: 10:15<br>

---
**e) TIME_FORMAT_LONG** - Hora no formato hh:mm:ss. Exemplo: 21:47:31

Neste [link](https://www.php.net/manual/pt_BR/function.date.php) você encontrará como pode personalizar a data e a hora para outros formatos desejados.

### 6. MULTI_LANGUAGE

Este parâmetro permite que o sistema exiba os recursos onde o usuário poderá escolher em qual linguagem o sistema será exibido.

---
Os valores possíveis são **true** ou **false**. Quando o valor estiver como **true** o sistema exibirá na tela de login e também no menu superior do dashboard do sistema os flags das linguagens disponíveis. Sendo que a linguagem default do sistema é **pt-BR**. Atualmente os valores possíveis são **pt-BR** e **en**.


> {success} Valor Padrão: **true**

<a name="section-06"></a>
## Executando a aplicação

Considerando que você já configurou seu ambiente apache ou nginx para apontar para a sua aplicação, agora você pode testar o projeto. Para isso, utilize um dos usuários abaixo para se identificar na tela de login.

| Nome do Usuário  | Papel      | Login                  | Senha    |
| ---------------- | ---------- | ---------------------- | -------- |
| **Super Admin**  | Superadmin | superadmin@gennix.test | superman |
| **Peter Markus** | Admin      | peter@gennix.test      | 12345678 |
| **Jane Garcez**  | User       | jane@gennix.test       | 12345678 |
