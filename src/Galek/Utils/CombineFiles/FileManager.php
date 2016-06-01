<?php

namespace Galek\Utils;

use Galek\Utils\Path;

class FileManager implements IFileManager
{
    /** @var string */
    private $path;

    /** @var string */
    private $root;

    public function __construct($root = null, $path = null)
    {
        $this->root = $root;
        $this->path = $path;
    }

    public function write($file, $content)
    {
          $file = $this->realFile($file, true);
          $fopen = fopen('nette.safe://'.$file, 'w+');
          fwrite($fopen, $content);
          fclose($fopen);
    }

    public function read($file)
    {
        $realFile = $this->realFile($file);
        $fopen = fopen('nette.safe://'.$realFile, 'r');
        $size = filesize($realFile);
        $content = false;
        if ($fopen) {
          $content = ($size > 0 ? fread($fopen, $size) : false);
        }
        fclose($fopen);
        return $content;
    }

    public function realFile($file, $writing = false)
    {

        $rootpath = Path::normalize($this->root.'/'.$this->path.'/'.$file);
        if (file_exists($rootpath)) {
            return $rootpath;
        }

        $real = Path::normalize($this->path.'/'.$file);
        if (file_exists($real)) {
            return $real;
        }

        $absolute = Path::normalize($file);
        if (file_exists($absolute)) {
            return $absolute;
        }

        if (!$writing) {
            throw new \Exception( "File '$file' does not exist." );
        } else {
            return $rootpath;
        }
    }
}
