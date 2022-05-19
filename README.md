# FaturHelper

<p align="center">
  <a href="https://packagist.org/packages/ajifatur/faturhelper"><img src="https://poser.pugx.org/ajifatur/faturhelper/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/ajifatur/faturhelper"><img src="https://poser.pugx.org/ajifatur/faturhelper/v/stable.svg" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/ajifatur/faturhelper"><img src="https://poser.pugx.org/ajifatur/faturhelper/license.svg" alt="License"></a>
  <a href="https://github.com/ajifatur/faturhelper/actions/workflows/main.yml"><img src="https://github.com/ajifatur/faturhelper/actions/workflows/main.yml/badge.svg?branch=master" alt="GitHub Action"></a>
  <a href="https://wakatime.com/@ajifatur"><img src="https://wakatime.com/badge/user/7096d127-6916-4f3e-add2-b7f5ca9e1b66/project/f840f725-5b03-4345-809c-24f1142d91ae.svg" alt="WakaTime"></a>
</p>

## Introduction

FaturHelper is the project that contains some helpers/functions/methods to help my Laravel work easier.

## Prerequisite
- PHP >= 7.4
- DBMS MySQL >= 6.0
- Laravel >= 8.0

## Installation (Version 2.0)

### Download From Composer:

Run this script into your CLI:

```sh
composer require ajifatur/faturhelper
```

### Configuration:

Add this script into `app/Providers/AppServiceProvider.php` inside of `register` method:

``` php
if(File::exists(base_path('vendor/ajifatur/faturhelper/src'))) {
    foreach(glob(base_path('vendor/ajifatur/faturhelper/src').'/Helpers/*.php') as $filename) {
        require_once $filename;
    }
}
```

## Installation (Version 3.0 or More)

### Download From Composer:

Run this script into your CLI:

```sh
composer require ajifatur/faturhelper
```

### Configuration:

Add this script into `config/app.php` in `providers` section:

``` php
Ajifatur\FaturHelper\FaturHelperServiceProvider::class,
```

Run this script into your CLI every after install or update the `faturhelper`:

```sh
php artisan faturhelper:install
```

### Enjoy!

## Docs
- [Helper](https://github.com/ajifatur/faturhelper/blob/master/readme/Helper.md)
- [Helper: Dataset](https://github.com/ajifatur/faturhelper/blob/master/readme/Dataset.md)
- [Helper: DateTime](https://github.com/ajifatur/faturhelper/blob/master/readme/DateTime.md)
- [Helper: File](https://github.com/ajifatur/faturhelper/blob/master/readme/File.md)
