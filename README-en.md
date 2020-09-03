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
If you prefer portuguese version, <a href="https://github.com/fsclaro/gennix/blob/master/README.md">click here</a>
</p>
<hr>

## Table of Contents
- [Table of Contents](#table-of-contents)
- [About this project](#about-this-project)
- [Minimal environment](#minimal-environment)
- [Packages included in the project](#packages-included-in-the-project)
  - [Production](#production)
  - [Development](#development)
- [Cloning](#cloning)
- [Creating the project parameters/configuration file](#creating-the-project-parametersconfiguration-file)
- [Preparing the database](#preparing-the-database)
  - [Configuring the database](#configuring-the-database)
- [Executing package installation commands and initial configurations](#executing-package-installation-commands-and-initial-configurations)
- [Other settings](#other-settings)
  - [DEBUGBAR](#debugbar)
  - [USE_SOCIALITE](#use_socialite)
    - [SOCIALITE_FACEBOOK, SOCIALITE_TWITTER, SOCIALITE_GITHUB, SOCIALITE_LINKEDIN, SOCIALITE_GOOGLE](#socialite_facebook-socialite_twitter-socialite_github-socialite_linkedin-socialite_google)
  - [EXTERNAL_IP](#external_ip)
  - [FOOTER_CENTER, FOOTER_LEFT, FOOTER_RIGHT](#footer_center-footer_left-footer_right)
  - [DATE AND TIME FORMATTING](#date-and-time-formatting)
  - [MULTI_LANGUAGE](#multi_language)
- [Running the application](#running-the-application)
- [Commands added to the composer](#commands-added-to-the-composer)
  - [*composer update**](#composer-update)
  - [*composer clear-all*](#composer-clear-all)
  - [*composer cache-all*](#composer-cache-all)
  - [*composer ide-helper*](#composer-ide-helper)
  - [*composer format*](#composer-format)
  - [*composer beautify*](#composer-beautify)
    - [For global installation](#for-global-installation)
    - [For local installation](#for-local-installation)
- [Internationalization](#internationalization)
- [CRUD](#crud)
- [Contributions](#contributions)
- [Code of conduct](#code-of-conduct)
- [Vulnerabilities and Security](#vulnerabilities-and-security)
- [License](#license)

<hr>

## About this project

The **gennix** project is intended to be a starting point for other projects based on the Laravel framework. This boilerplate contains a series of packages that will allow you to speed up the construction of your WEB projects.

## Minimal environment

To install and use **gennix** the minimum configuration required is:

* PHP: 7.2
* Laravel: 7.*

## Packages included in the project

This project uses the following third party packages

### Production

* arcanedev/log-viewer
* arcanedev/route-viewer
* arrilot/laravel-widgets
* barryvdh/laravel-snappy
* beyondcode/laravel-self-diagnosis
* binarytorch/larecipe
* creativeorange/gravatar
* davejamesmiller/laravel-breadcrumbs
* h4cc/wkhtmltoimage-amd64
* h4cc/wkhtmltopdf-amd64
* jeremykenedy/laravel-phpinfo
* jeroennoten/laravel-adminlte
* laravel/socialite
* laravel/ui
* maatwebsite/excel
* realrashid/sweet-alert
* renatomarinho/laravel-page-speed
* spatie/laravel-activitylog
* spatie/laravel-backup
* spatie/laravel-medialibrary
* spatie/laravel-sluggable
* yajra/laravel-datatables-oracle

### Development

* barryvdh/laravel-debugbar
* barryvdh/laravel-ide-helper
* matt-allan/laravel-code-style
* squizlabs/php_codesniffer

## Cloning

To use and/or test this project, you must type the following lines below in your terminal

```bash
git clone git@github.com:fsclaro/gennix.git
```

After cloning is complete, you must perform the initial configuration. To do this, follow the steps below:

## Creating the project parameters/configuration file

Being in the terminal and inside the project folder, type the line below to copy the sample environment configuration file

```bash
cp .env.example .env
```

## Preparing the database

You can create the database directly on the command line using the instruction below.

```bash
mysql -e 'create database <YOUR_DATABASE_NAME>;' -u <YOUR_MYSQL_USERNAME> -p
```

CIf you prefer, use a database manager program of your choice.

### Configuring the database

Edit the *.env* file and modify the parameters below, according to the information you use to access your database

```bash
DB_DATABASE=<YOUR_DATABASE_NAME>
DB_USERNAME=<YOUR_MYSQL_USERNAME>
DB_PASSWORD=<PASSWORD_OF_YOUR_MYSQL_USERNAME>
```

The initial values of these parameters are:

```bash
DB_DATABASE=gennix
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## Executing package installation commands and initial configurations

At the terminal, execute the following commands:

```bash
composer install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

## Other settings

In the *.env* file you will find other configurations that can be made. These are described below.

### DEBUGBAR

The *DEBUGBAR_ENABLED* parameter must be enabled or disabled depending on the environment where you are running the project. For the development environment you can activate this feature, in case you need to perform debugging during the creation and testing of your project.

But for the production environment, I strongly recommend that you leave it disabled so that there are no project performance problems.

The allowed values for this parameter are: *true* or *false*

### USE_SOCIALITE

If you want to allow system users access through social networks, you must set this parameter to *true*. In doing so, * gennix * will understand that it should display the social media buttons on the login screen so that users can identify themselves in this way.

Activating this feature, you must choose at least one of the social networks available in **gennix**, described below:

#### SOCIALITE_FACEBOOK, SOCIALITE_TWITTER, SOCIALITE_GITHUB, SOCIALITE_LINKEDIN, SOCIALITE_GOOGLE

Select which social networks will be released so that the user can log in to the system. The parameters that must be configured for each of them are:

| Social network | Activation              | Access parameters                             |
| -------------- | ----------------------- | --------------------------------------------- |
| Facebook       | SOCIALITE_FACEBOOK=true | FACEBOOK_CLIENT_ID and FACEBOOK_CLIENT_SECRET |
| Twitter        | SOCIALITE_TWITTER=true  | TWITTER_CLIENT_ID and TWITTER_CLIENT_SECRET   |
| GitHub         | SOCIALITE_GITHUB=true   | GITHUB_CLIENT_ID and GITHUB_CLIENT_SECRET     |
| LinkedIn       | SOCIALITE_LINKEDIN=true | LINKEDIN_CLIENT_ID and LINKEDIN_CLIENT_SECRET |
| Google         | SOCIALIE_GOOGLE=true    | GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET     |

To define the CLIENT_ID and CLIENT_SECRET values for your chosen social networks, use the following links:

* [Facebook](https://developers.facebook.com/apps/)
* [Twitter](https://developer.twitter.com/en/apps)
* [Github](https://github.com/settings/applications/new)
* [LinkedIn](https://www.linkedin.com/developers/)
* [Google](https://console.cloud.google.com)

To configure access through other social networks, see more details through this [link](https://socialiteproviders.com/).

To add other social networks, in addition to creating the parameters in the *.env* file, you must also edit the */config/services.php* file and add the equivalent entries as in the example below:

```php
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('APP_URL') . '/login/linkedin/callback',
    ],
```

You should also change the file */resources/views/vendor/adminlte/auth/login.blade.php* to add the code needed for the system to understand that you are giving access to a new social network.

Locate in the code the section where the links for accessing the social network are treated and add the code as the example below, making the necessary adaptations:

```php
    @if(env('SOCIALITE_GOOGLE'))
    <a href="{{ route('login.social', 'google') }}"
        class="btn google-color rounded-circle mx-1">
        <i class="fab fa-google"></i>
    </a>
    @endif
```

>**IMPORTANT**: The use of the login feature through social networks implemented in the project, is solely and exclusively to perform access authentication. The possibility of registering new users through social networks was not implemented in the project. Even though it is a feature that you would easily implement in the project.


### EXTERNAL_IP

One of the features provided in *gennix* is the registration of the IP of the user who is accessing the application. For this, the services of the IPIFY provider are used. If you want to change the provider that will identify your client's IP, just define the URL of this client in this parameter.

>Default value:<br>
EXTERNAL_IP=https://api.ipify.org


### FOOTER_CENTER, FOOTER_LEFT, FOOTER_RIGHT

These parameters allow you to customize the footer of the application. For this, you have two options:

**a) Centralized footer**

To have a text that will be centered at the bottom of the page, you only need to define the content in the parameter *FOOTER_CENTER*.

**b) Left and right footer**

The other option will be to define the text you want both on the left and on the right side in the parameters *FOOTER_LEFT* and *FOOTER_RIGHT* respectively.

If you set values for the three parameters, *FOOTER_CENTER* will take precedence, ignoring the parameters *FOOTER_LEFT* and *FOOTER_RIGHT*.

These parameters accept HTML tags so that you can use your creativity to build the footer in the most appropriate way for your application.

### DATE AND TIME FORMATTING

The parameters below, allow you to define the date and time format that will be used in the application.

**a) DATE_FORMAT** - Date in the format mm/dd/yy. Example: 05/10/20 <br>
**b) DATE_FORMAT_LONG** - Date in dd/mm/yyyy format. Example: 08/15/2020 <br>
**c) DATE_FORMAT_LONG_LONG** - Date in day-of-week format, month-in-length dd of yyyy. Example: Thursday, 10 March 2020 <br>
**d) TIME_FORMAT** - Time in hh:mm format. Example: 10:15 <br>
**e) TIME_FORMAT_LONG** - Time in the format hh:mm:ss. Example: 21:47:31

In this [link](https://www.php.net/manual/pt_BR/function.date.php) you will find how you can customize the date and time for other desired formats.

### MULTI_LANGUAGE
This parameter allows the system to display the resources where the user can choose in which language the system will be displayed.

Possible values are **true** or **false**. When the value is ** true ** the system will display the flags of the available languages on the login screen and also on the top menu of the system dashboard. The default language of the system is **pt-BR**. Currently, the possible values are **pt-BR** and **en**.


>Default value: **true**

## Running the application

Considering that you have already configured without an apache or nginx environment to point to your application, you can now test the project. To do this, use one of the users below to identify yourself on the login screen

| Name             | Role       | Login                  | Password |
| ---------------- | ---------- | ---------------------- | -------- |
| **Super Admin**  | Superadmin | superadmin@gennix.test | superman |
| **Peter Markus** | Admin      | peter@gennix.test      | 12345678 |
| **Jane Garcez**  | User       | jane@gennix.test       | 12345678 |


## Commands added to the composer

*Gennix* has some complementary commands to the composer. These complementary commands can be found in the *_composer.json_* file.

Below, I describe the new commands and what each of them does.

### *composer update**

After updating and / or installing the packages, the *clear-all* command described below will be executed.

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

>NOTE: the commands *_format_* and *_beautify_* require the php-cs-fixer package installed globally or locally in your environment. If you do not have this package installed, execute one of the commands below, as needed, to perform the installation.

#### For global installation

```bash
composer global require friendsofphp/php-cs-fixer
```

#### For local installation

```bash
composer require friendsofphp/php-cs-fixer --dev
```


## Internationalization

The *gennix* project is initially configured for Brazilian Portuguese. The parameters that define the language the environment will use are defined in the file */config/app.php*. The main parameters are:

**a) timezone** - America/Sao_Paulo<br>
**b) locale** - pt-BR

If you want to use the system in a language other than Brazilian Portuguese or English, you can translate the files containing all messages displayed on the system. Below I describe the locations where these files are located and what they are used for.

* /resources/lang/pt-BR/gennix.php - contains system-specific messages
* /resources/lang/vendor/adminlte - contains the adminlte message files

## CRUD

This project has a resource to create the basic CRUD that will allow to accelerate the development of the project.

This feature is obtained by executing the following command:

```bash
php artisan gennix:crud <options> <name>
```

* **name** - is the name of the CRUD class you want to create.
>IMPORTANT: The name of the class must be in the singular, with the first letter in Uppercase. More details you can see [here](https://github.com/php-fig/fig-standards).

* **options** - can be:

| Key           | What will be created                        | Location where files will be created |
| ------------- | ------------------------------------------- | ------------------------------------ |
| --controller  | Controller                                  | /app/Http/Controller                 |
| --model       | Model                                       | /app                                 |
| --request     | Requests (update and store)                 | /app/Http/Requests                   |
| --views       | Views (index, create, edit, show)           | /resources/views/admin               |
| --breadcrumbs | Breadcrumbs to all CRUD operations          | /routes                              |
| --routes      | Resources route                             | /routes                              |
| --migrations  | Migration                                   | /database/migrations                 |
| --all         | All resrouces above                         | ---                                  |

*Example:*

```bash
php artisan gennix:crud --all Client
```

If you need to customize the templates that are used to generate the created files, just edit the *stubs* that are located in */resources/views/stubs*.

After you have created the new CRUD, don't forget to edit the *config/adminlte.php* file and in the *menu* section add and/or change the parameters so that the new CRUD appears in the system menu. Locate the section below and make the necessary adjustments.

```php
// [
//     'text'  => 'audit',
//     'icon'  => 'fa fa-fw fa-binoculars',
//     'route' => 'audit.index',
//     'can'   => 'audit-access'
// ],
```

Also, if applicable, create the necessary permissions and roles for the new CRUD.


## Contributions

If you are interested in contributing to the *gennix* project improvements with good ideas or reporting _bugs_ or any other type of problem, please read the [contribution guide](https://github.com/fsclaro/gennix/blob/master/CONTRIBUTING.md) and register a PR (pull request) or a Issue.

## Code of conduct

It is very important that you read the [code of conduct](https://github.com/fsclaro/gennix/blob/master/CODE_OF_CONDUCT.md) so that there is peaceful coexistence among the members participating in this project.

## Vulnerabilities and Security

If you discover any security vulnerabilities in this project, please send an email to [Nando Salles](mailto:fsclaro@gmail.com).

## License

This project is licensed under the [MIT license](https://github.com/fsclaro/gennix/blob/master/LICENSE.md).
