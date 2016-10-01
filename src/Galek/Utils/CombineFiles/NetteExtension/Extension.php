<?php

namespace Galek\Utils\CombineFiles\DI;

use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\DI\Config\Helpers;
use Nette\DI\ContainerBuilder;
use Nette\Utils\Finder;
use Nette;
use Galek\Utils\CombineFiles;

class Extension extends Nette\DI\CompilerExtension
{

    public $defaults = [
        'root' => __DIR__,
        'localPath' => 'css'
    ];

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);
        $combiner = $builder->addDefinition($this->prefix('combineFiles'))
            ->setClass(CombineFiles::class);

        $combiner->setFactory(CombineFiles::class, [$config]);
    }
}
