- [Composer](#section-01)
  - [Comandos adicionados ao composer](#section-02)
    - [composer update](#section-03)
    - [composer clear-all](#section-04)
    - [composer cache-all](#section-05)
    - [composer ide-helper](#section-06)
    - [composer format](#section-07)
    - [composer beautify](#section-08)

<a name="section-01"></a>
# Composer

Nesta seção são descritas as novas funcionalidades que foram implementadas ao gerenciador de pacotes **composer**.
Os comandos descritos abaixo devem ser executados somente durante a fase de desenvolvimento do sistema e/ou quando
for necessária alguma ação específica no ambiente de produção.


<a name="section-02"></a>
## Comandos adicionados ao composer

O **gennix** possui alguns comandos complementares implementador no composer. Estes comandos podem ser encontrados no arquivo *_composer.json_*.

Abaixo, estão descritos os novos comandos e o que cada um deles fazem.

<a name="section-03"></a>
### a) composer update
Após a atualização e/ou instalação dos pacotes, será executado o comando *clear-all* descrito a seguir.

<a name="section-04"></a>
### b) composer clear-all

* artisan clear-compiled
* artisan cache:clear
* artisan route:clear
* artisan view:clear
* artisan config:clear
* composer dumpautoload -o

<a name="section-05"></a>
### c) composer cache-all

* artisan config:cache
* artisan route:cache

<a name="section-06"></a>
### d) composer ide-helper

* artisan ide-helper:generate
* artisan ide-helper:meta

<a name="section-07"></a>
### e) composer format

* php-cs-fixer fix app/ --show-progress=estimating
* php-cs-fixer fix config/ --show-progress=estimating
* php-cs-fixer fix database/ --show-progress=estimating
* php-cs-fixer fix resources/ --show-progress=estimating
* php-cs-fixer fix routes/ --show-progress=estimating
* php-cs-fixer fix tests/ --show-progress=estimating

<a name="section-08"></a>
### f) composer beautify

* phpcbf --standard=PSR2 -p app/*
* phpcbf --standard=PSR2 -p database/*
* phpcbf --standard=PSR2 -p resources/*

> {info} OBS: os comandos *_format_* e *_beautify_* necessitam do pacote **friendsofphp/php-cs-fixer** instalado de forma global ou local no seu ambiente. Caso você não tenha este pacote instalado, execute um dos comandos abaixo, conforme sua necessidade.

#### Instalação global

```bash
composer global require friendsofphp/php-cs-fixer
```
---

#### Instalação local

```bash
composer require friendsofphp/php-cs-fixer --dev
```
