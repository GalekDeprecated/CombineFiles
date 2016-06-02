<?php

namespace Galek\Utils\Nette;

use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\DI\Config\Helpers;
use Nette\DI\ContainerBuilder;
use Nette\Utils\Finder;
use Nette;

class Extension extends CompilerExtension
{

    public function getDefaultConfig()
    {
        return [
          'js' => [],
          'css' => [],
        ];
    }

    public function loadConfig()
    {

    }
}
