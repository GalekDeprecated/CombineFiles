<?php

namespace Galek\Utils;

use Galek\Utils\Path;
use Galek\Utils\FileManager;
/**
 * @author Jan Galek
 */
class CombineFiles implements ICombineFiles
{

    /** @var array */
    private $files = [];

    /** @var string */
    private $path;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var FileManager */
    private $fmanager;

    public function __construct($path = null, $name = 'combined')
    {
        $this->path = $path;
        $this->name = $name;
        $this->fmanager = new FileManager($path);
    }

    public function getFiles()
    {
        $files = array_values($this->files);
        foreach ($files as $file) {
            if (!isset($type)) {
                $type = pathinfo($this->realFile($file))['extension'];
                $this->type = $type;
            }

            if (pathinfo($this->realFile($file))['extension'] != $type) {
                $badtype = pathinfo($file)['extension'];
                throw new \Exception("Was set type '$type', but '$file' is '$badtype'");
            }
        }
        return array_values($this->files);
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

    public function addFile($file)
    {
        $realFile = $this->realFile($file);

        if (in_array($realFile, $this->files, true)) {
            return;
        }
        $this->files[] = $file;
    }

    public function addFiles($files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }

    public function removeFiles(array $files)
    {
        $files = array_map([$this, 'realFile'], $files);
        $this->files = array_diff($this->files, $files);
    }

    public function removeFile($file)
    {
        $this->removeFiles([$file]);
    }

    public function clear()
    {
        $this->files = [];
    }

    public function getPath()
    {
        return $this->path;
    }

    public function compile()
    {

        $ttt = __DIR__.'/test';
        $files = $this->getFiles();
        $contents = '';
        $createJson = [];
        foreach ($files as $file) {
              $contents .= $this->fmanager->read($file, $this->path);
              $time = filemtime($this->realFile($file));
              $createJson[$file] = $time;
        }
        $combineFile = $this->path.'/'.$this->name.'.'.$this->type;
        $lockFile = $combineFile.'.lock';

        if (file_exists($lockFile)) {
            $json = $this->fmanager->read($lockFile);

            if ($json != json_encode($createJson)) {
                $this->fmanager->write($lockFile, json_encode($createJson));
                $this->fmanager->write($combineFile, $contents);
            }
        } else {
            $this->fmanager->write($combineFile, $contents);
            $this->fmanager->write($lockFile, json_encode($createJson));
        }
    }

    public function __destruct()
    {
        $this->compile();
    }
}
