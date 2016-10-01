<?php

namespace Galek\Utils;

use Galek\Utils\CombineFiles;

class Compiler implements ICompiler
{

    /** @var CombineFiles */
    private $manager;

    /** @var IJsonChecker */
    private $checker;

    public function __construct(IFileManager $manager = null, IJsonChecker $checker = null)
    {
        $this->manager = $manager;
        $this->checker = $checker;
    }

    public function compile($files = [], $root = null, $path = null, $name = 'combined', $type = null)
    {
        $createJson = [];
        $combineFile = $name.'.'.$type;
        $combineRealFile = $root.'\\'.$path.'\\'.$name.'.'.$type;
        $lockFile = $combineFile.'.lock';

        if (!$this->checker->checkFiles($files, $lockFile)) {
            foreach ($files as $file) {
                  $this->manager->write($combineFile, $file);
                  $time = filemtime($this->manager->realFile($file));
                  $createJson[$file] = $time;
            }
            $this->manager->writeLock($lockFile, json_encode($createJson));
        }
        return $path.'/'.$combineFile;
    }
}
