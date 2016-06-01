# CombineFiles

## Example
/--php
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
--/
