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
  $path = 'css';
  $root = __DIR__;
  $basic = new \Galek\Utils\CombineFiles($root, $path);
  $basic->addFile('main.css');
  $basic->addFile('top.css');
  $basic->addFile('bot.css');
  ?>
  <link rel="stylesheet" type="text/css" href="<?php echo $basic; ?>">

  <h1>Tested</h1>
```

## Example with Nette Extension
```neon
extensions:
	css: \Galek\Utils\CombineFiles\DI\Extension
	js: \Galek\Utils\CombineFiles\DI\Extension

css:
	root: ::constant(WWW_DIR) // we can use constant, which we defined for example at index.php
	localPath: 'css'
	files:
		- style.min.css
		- nittro.full.min.css

js:
	root: ::constant(WWW_DIR)
	localPath: 'js'
	name: 'myCombinedFile' //We can named outside file
	files:
		- main.js
		- nittro.full.min.js
```

```php
    public function startup()
    {
        parent::startup();
        $this->cssCombinator = $this->context->getService('css.combineFiles');
    }

    protected function beforeRender()
    {
        parent::startup();
        $this->template->cssCombined = $this->cssCombinator;
    }
```

```latte
    <head>
        <link rel="stylesheet" type="text/css" href="{$cssCombined}">
    </head>
```
