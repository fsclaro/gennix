<p align="center">
<img src="https://github.com/fsclaro/blackbird7/blob/master/public/img/front-page.png">
</p>

## About this project

The **gennix7 Project** is intended to be a starting point for other projects based on the Laravel framework. Containing in this boilerplate several packages that can aid and accelerate the construction of your web projects.

## Laravel Environment

- PHP Version: ^7.3
- Laravel Version: 7.*
- Timezone: America/Sao_Paulo
- Locale: pt_BR
- Database: MySQL/MariaDB

## Third-party Packages included

- arcanedev/log-viewer
- arcanedev/route-viewer
- creativeorange/gravatar
- davejamesmiller/laravel-breadcrumbs
- jeroennoten/laravel-adminlte
- laravel/socialite
- yajra/laravel-datatables-oracle
- laravel/ui

## Third-party Packages for Development Mode included

- arryvdh/laravel-debugbar
- barryvdh/laravel-ide-helper
- matt-allan/laravel-code-style
- squizlabs/php_codesniffer

## Cloning this project

To use this project, you must type the following line in your command terminal
```bash
git clone git@github.com:fsclaro/gennix.git
```

You will need a mysql server installed e configured, then execute the command below to create a database for the your project.
```bash
mysql -e 'create database <YOUR_DATABASE_NAME>;' -u <YOUR_MYSQL_USERNAME> -p
```

Edit the *.env* file to modify the parameters below, according your database environment
```bash
DB_DATABASE=<YOUR_DATABASE_NAME>
DB_USERNAME=<YOUR_MYSQL_USERNAME>
DB_PASSWORD=<PASSWORD_OF_YOUR_MYSQL_USERNAME>
```

The default values are
```bash
DB_DATABASE=gennix
DB_USERNAME=homestead
DB_PASSWORD=secret
```

After, run commands bellow in terminal:
```bash
composer install
php artisan storage:link
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Defaults Login Users
This boilerplate have two defaults users

| User           | Login               | Password |
|----------------|---------------------|----------|
| **SuperAdmin** | superadmin@bb7.test | superman |
| **Admin**      | admin@bb7.test      | password |
| **User**       | user@bb7.test       | password |


## New composer commands
### 1) *composer clear-all*, execute:
* artisan clear-compiled
* artisan cache:clear
* artisan route:clear
* artisan view:clear
* artisan config:clear
* composer dumpautoload -o

### 2) *composer cache-all*, execute:
* artisan config:cache
* artisan route:cache

### 3) *composer ide-helper*, execute:
* artisan ide-helper:generate
* artisan ide-helpder:meta

### 4) *composer format*, execute:
* php-cs-fixer fix app/ --show-progress=estimating
* php-cs-fixer fix config/ --show-progress=estimating
* php-cs-fixer fix database/ --show-progress=estimating
* php-cs-fixer fix resources/ --show-progress=estimating
* php-cs-fixer fix routes/ --show-progress=estimating
* php-cs-fixer fix tests/ --show-progress=estimating

## Internalization

This project is configured for the Brazilian Portuguese Language with the *timezone* configured for **America/Sao_Paulo**, *locale* for **pt-br** and *faker_locale* for *pt_BR*. If you are of another nationality, simply edit the *config/app.php* file and customize the *timezone* and *locale* parameters according to your need.


## Contributing

Thank you for considering contributing to the *gennix project*! If you have good ideas to make this project better, read the [contribution guidelines](https://github.com/fsclaro/gennix/blob/master/_docs/CODE_OF_CONDUCT.md) on contributions and send me an email to [fsclaro@gmail.com](mailto:fsclaro@gmail.com)

## Code of Conduct

It is very important that you read our [code of conduct](https://github.com/fsclaro/gennix/blob/master/_docs/CODE_OF_CONDUCT.md) so that there is a healthy coexistence among all members participating in this project.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to _*Nando Salles*_ at [fsclaro@gmail.com](mailto:fsclaro@gmail.com). All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://github.com/fsclaro/gennix/blob/master/_docs/LICENSE.md).
