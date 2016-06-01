<?php

namespace Galek\Utils;

use Galek\Utils\Path;

class FileManager
{
    private $path;

    public function __construct($path = null)
    {
        $this->path = $path;
    }

    public function write($file, $content)
    {
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

    public function compare($text, $compare)
    {

    }

    private function realFile($file, $path = '')
    {
        $real = Path::normalize($this->path.'/'.$file);
        if (file_exists($real)) {
            return $real;
        }

        $absolute = Path::normalize($file);
        if (file_exists($absolute)) {
            return $absolute;
        }

        throw new \Exception( "File '$file' does not exist." );
    }
}
