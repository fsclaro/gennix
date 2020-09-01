- [CRUD](#section-01)
- [Comando de criação do CRUD](#section-02)
- [Permissões criadas](#section-03)
- [Personalizando os stubs](#section-04)
- [Ajustando o menu](#section-05)
- [Internacionalização](#section-06)


<a name="section-01"></a>
# CRUD

---

O **gennix** dispõe de um recurso de criação de um CRUD básico que permitirá acelerar o desenvolvimento do seu projeto.

---

<a name="section-02"></a>
## Comando de criação do CRUD

Este recurso é obtido através da execução do seguinte comando:

```bash
php artisan gennix:crud <options> <model_name>
```

Onde:
* **model_name** - é o nome da classe do CRUD que deseja criar.

> {info} IMPORTANTE: O nome da classe deve estar no singular sendo que a primeira letra em Maiúscula. Maiores detalhes você pode ver [aqui](https://github.com/php-fig/fig-standards).

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
| --permissions | Permissões básicas da classe                | **tabela permissions**               |
| --all         | Todos os recursos acima descritos           | **não se aplica**                    |


---
**Exemplos:**

---

Para criar **somente o controller**, utilize o comando:
```bash
php artisan gennix:crud --controller Estoque
````

---
Para criar **as rotas e a migrations**, utilize o comando:
```bash
php artisan gennix:crud --routes --migrations Estoque
```

---
Para criar todos os recursos do CRUD, utilize o comando:
```bash
php artisan gennix:crud --all Estoque
```

---

<a name="section-03"></a>
## Permissões criadas

O parâmetro **--permissions** criará as permissões básicas na tabela **permissions** do sistema.

---

**Exemplo:** Supondo que o comando CRUD executado foi.

---

```php
php artisan gennix:crud --permissions Client
```

---

As permissões que serão criadas são:

| Descrição da permissão           | Slug/Chave        |
|----------------------------------|-------------------|
| Acessar o cadastro de cliente    | client**-access** |
| Criar um novo cliente            | client**-create** |
| Editar os dados de um cliente    | client**-edit**   |
| Exibir os detalhes de um cliente | client**-show**   |
| Excluir o registro de um cliente | client**-delete** |

---

Após criadas as permissões, você também deverá associá-las a um determinado **papel** para que os novos recursos fiquem disponíveis aos usuários do sistema.

---

<a name="section-04"></a>
## Personalizando os stubs

Caso você necessite personalizar as templates que são utilizadas para a geração dos arquivos criados, basta editar os **stubs** que estão localizados em **/resources/views/stubs**.

---

<a name="section-05"></a>
## Ajustando o menu

Depois que você criou o novo CRUD, não se esqueça de editar o arquivo **config/adminlte.php** e na seção **menu** adicionar e/ou alterar os parâmetros para que o novo CRUD apareça no menu do sistema. Localize o trecho abaixo e faça os ajustes necessários.

```php
// [
//     'text'  => 'audit',
//     'icon'  => 'fa fa-fw fa-binoculars',
//     'route' => 'audit.index',
//     'can'   => 'audit-access'
// ],
```

---

<a name="section-06"></a>
## Internacionalização

Por último, não se esqueça de adicionar também os textos das telas e menu conforme descrito no ítem de
internacionalização desta documentação. Para saber mais, [clique aqui](/{{route}}/{{version}}/i18n).
