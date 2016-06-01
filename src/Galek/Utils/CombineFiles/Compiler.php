<?php

namespace Galek\Utils;

class Compiler
{
    /** @var string */
    private $outputDir;

    /** @var ILoadFiles */
    private $loadedFiles;

    public function __construct(ICombineFiles $files, $outputDir)
    {
        $this->loadedFiles = $files;
        $this->outputDir = $outputDir;
    }

    public static function create(ILoadFiles $files, $outputDir)
    {

    }
}
