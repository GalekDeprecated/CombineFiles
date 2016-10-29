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
        if (file_exists($this->fmanager->realFile($lockFile, false, false))) {
            $lock = $this->fmanager->read($lockFile);
            $json = json_decode($lock);
            foreach ($files as $file) {
                if (!$json) {
                    return false;
                }
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
            $this->fmanager->writeLock($lockFile, '{}');
            return false;
        }
    }

    public function checkFile($file, $time)
    {
        $actual = filemtime($this->fmanager->realFile($file));
        return ($actual == $time);
    }
}
