<?php

namespace Galek\Utils;

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

    public function __construct($path = null, $name = 'combined')
    {
        $this->path = $path;
        $this->name = $name;
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
        //$timing = "{\n";
        foreach ($files as $file) {
            $fopen = fopen('nette.safe://'.$this->realFile($file), 'r');
            $size = filesize($this->realFile($file));
            $time = filemtime($this->realFile($file));
            if ($size > 0) {
              $contents .= fread($fopen, filesize($this->realFile($file)));
              $createJson[$file] = $time;
              //$timing .= "\t".$file.": ".$time.",\n";
            }
            fclose($fopen);
        }
        //$timing .= "}";


        //$timing = md5($timing);
        //var_dump($timing);
        $lockFile = $this->path.'/'.$this->name.'.'.$this->type.'.lock';
        $fopen = fopen('nette.safe://'.$lockFile, 'w+');
        $json = fread($fopen, filesize($lockFile));
        var_dump(json_decode($json));
        //fwrite($fopen, $timing);
        fwrite($fopen, json_encode($createJson));
        fclose($fopen);

        $fopen = fopen('nette.safe://'.$this->path.'/'.$this->name.'.'.$this->type,'w+');
        fwrite($fopen, $contents);
        fclose($fopen);
    }

    public function __call($name, $arguments)
    {
        $ttt = __DIR__.'/test';
        echo (string) $ttt;
    }

    public function __destruct()
    {
        $this->compile();
    }
}
