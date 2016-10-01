<?php

namespace Galek\Utils;

use Galek\Utils\Path;
use Galek\Utils\FileManager;
use Galek\Utils\JsonChecker;
use Galek\Utils\IFileManager;
use Galek\Utils\IJsonChecker;
use Galek\Utils\Compiler;
use Galek\Utils\ICompiler;
/**
 * @author Jan Galek
 */
class CombineFiles implements ICombineFiles
{
    /** @var array */
    private $files = [];

    /** @var string */
    private $root;

    /** @var string */
    private $path;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var IFileManager */
    private $fmanager;

    /** @var IJsonChecker */
    private $checker;

    /** @var ICompiler */
    private $compiler;

    /** @var string */
    private $combined;

    public function __construct($root, $path = null, $name = 'combined', IFileManager $manager = null, IJsonChecker $checker = null, ICompiler $compiler = null)
    {
        $this->root = $root;
        $this->path = $path;
        $this->name = $name;
        $this->fmanager = ($manager ? $manager : new FileManager($this->root, $path));
        $this->checker = ($checker ? $checker : new JsonChecker($this->fmanager));
        $this->compiler = ($compiler ? $compiler : new Compiler($this->fmanager, $this->checker));

    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->getType();
    }

    public function addFile($file)
    {
        $realFile = $this->fmanager->realFile($file);

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

    public function getFiles()
    {
        $files = array_values($this->files);
        foreach ($files as $file) {
            if (!isset($type)) {
                $type = pathinfo($this->fmanager->realFile($file))['extension'];
                $this->type = $type;
            }

            if (pathinfo($this->fmanager->realFile($file))['extension'] != $type) {
                $badtype = pathinfo($file)['extension'];
                throw new \Exception("Was set type '$type', but '$file' is '$badtype'");
            }
        }
        return array_values($this->files);
    }

    public function __toString()
    {
        if (!isset($this->combined)) {
            $this->combined = $this->compiler->compile($this->getFiles(), $this->root, $this->path, $this->name, $this->type);
        }
        return $this->combined;
    }
}
