<?php

require __DIR__.'/../../vendor/autoload.php';

use Galek\Utils;
use Galek\Utils\CombineFiles;
use Tracy\Debugger;

Debugger::enable(__DIR__ . '/log'); // aktivujeme Laděnku

$e = new Utils\CombineFiles\DI\Extension;

$path = 'css';
$root = __DIR__;
$t = new Utils\CombineFiles($root, $path);
$t->addFile('style_bot.css');
$t->addFile('style_top.css');
$t->addFile('style_effects.css');
$t->addFile('style_critical.css');

?>
<link rel="stylesheet" type="text/css" href="<?php echo $t; ?>">

<h1>Tested</h1>
