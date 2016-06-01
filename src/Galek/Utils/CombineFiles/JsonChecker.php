<?php

namespace Galek\Utils;
use Galek\Utils\IFileManager;

class JsonChecker implements IJsonChecker
{
    private $fmanager;

    public function __construct(IFileManager $manager)
    {
          $this->fmanager = $manager;
    }

    public function checkFiles($files, $lockFile)
    {
          if (file_exists($lockFile)) {
              $lock = $this->fmanager->read($lockFile);
              $json = json_decode($lock);
              foreach ($files as $file) {
                  if (!$json->$file) {
                      return false;
                  }
                  $time = $json->$file;
                  if (!$this->checkFile($file, $time)) {
                      return false;
                  }
              }
              return true;
          } else {
              $this->fmanager->write($lockFile, '{}');
              return false;
          }
    }

    public function checkFile($file, $time)
    {
        $actual = filemtime($this->fmanager->realFile($file));
        return ($actual == $time);
    }
}
