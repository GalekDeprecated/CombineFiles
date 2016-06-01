[![Travis] (https://travis-ci.org/JanGalek/combine-files.svg?branch=master)](https://travis-ci.org/JanGalek/combine-files)
[![Downloads this Month](https://img.shields.io/packagist/dm/galek/combine-files.svg)](https://packagist.org/packages/galek/combine-files)

# CombineFiles
Fast resolve for Google PageSpeed Insights combine warning (more css files). Now you can use generate for merge all files what you need to one file.

Package Installation
-------------------

The best way to install Combine Files is using [Composer](http://getcomposer.org/):

```sh
$ composer require galek/combine-files
```

[Packagist - Versions](https://packagist.org/packages/galek/combine-files)

or manual edit composer.json in your project

```json
"require": {
    "galek/combine-files": "^1"
}
```

## Importat settings
You need set rootPath to parent directory of your path
```php
$rootPath = __DIR__;
```

Also you set path/directory where are your files to merge.
```php
$path = 'css';
```

## Example
```php
  use Galek\Utils;
  use Galek\Utils\CombineFiles;

  class Basic
  {
      public function render()
      {
          $path = 'css';
          $root = __DIR__;
          $t = new Utils\CombineFiles($root, $path);
          $t->addFile('main.css');
          $t->addFile('top.css');
          $t->addFile('bot.css');
          return $t;
      }
  }

  $basic = new Basic();
  ?>
  <link rel="stylesheet" type="text/css" href="<?php $basic->render(); ?>">

  <h1>Tested</h1>
```
