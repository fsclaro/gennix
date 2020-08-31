- [CRUD](#section-01)

<a name="section-01"></a>
# CRUD

Este projeto dispõe de um recurso de criação da CRUD básica que permitirá acelerar o desenvolvimento do projeto.

---

Este recurso é obtido através da execução do seguinte comando:

```bash
php artisan gennix:crud <options> <name>
```

Onde:
* **name** - é o nome da classe do CRUD que deseja criar.

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
| --all         | Todos os recursos acima descritos           | *não se aplica*                      |


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

Caso você necessite personalizar as templates que são utilizadas para a geração dos arquivos criados, basta editar
os *stubs* que estão localizados em */resources/views/stubs*.

---

Depois que você criou o novo CRUD, não se esqueça de editar o arquivo *config/adminlte.php* e na seção *menu*
adicionar e/ou alterar os parâmetros para que o novo CRUD apareça no menu do sistema. Localize o trecho abaixo e faça
os ajustes necessários.

```php
// [
//     'text'  => 'audit',
//     'icon'  => 'fa fa-fw fa-binoculars',
//     'route' => 'audit.index',
//     'can'   => 'audit-access'
// ],
```

---

Estando no dashboard do sistema, como superadmin, crie as permissões necessárias para que o CRUD seja visualizado
e as funções sejam liberadas.

---
Na tabela abaixo estão descritas quais são as permissões que devem ser criadas, considere que foi criado um CRUD
chamado Client.

| Descrição da permissão           | Slug              |
|----------------------------------|-------------------|
| Acessar o cadastro de cliente    | client**-access** |
| Criar um novo cliente            | client**-create** |
| Editar os dados de um cliente    | client**-edit**   |
| Exibir os detalhes de um cliente | client**-show**   |
| Excluir o registro de um cliente | client**-delete** |

---
Após criadas as permissões, você também deverá associá-las a um determinado papel para que os novos recursos fiquem
disponíveis aos usuários do sistema.

---
Por último, não se esqueça de adicionar também os textos das telas e menu conforme descrito no ítem de
interncionalização desta documentação. Para saber mais, [clique aqui](/{{route}}/{{version}}/i18n).
