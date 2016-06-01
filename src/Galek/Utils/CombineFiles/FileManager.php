<?php

namespace Galek\Utils\CombineFiles;

class FileManager implements IFileManager
{

    public function write($file, $content)
    {

    }

    public function read($file)
    {
        $realFile = $this->realFile($file);
        $fopen = fopen('nette.safe://'.$realFile, 'r');
        $size = filesize($realFile);
        $content = ($size > 0 ? fread($fopen, $size) : false);
        fclose($fopen);
        return $content;
    }

    public function compare($text, $compare)
    {

    }

    private function realFile($file)
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
