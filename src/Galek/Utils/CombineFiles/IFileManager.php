<?php

namespace Galek\Utils;

interface IFileManager
{
    public function read($file);

    public function write($file, $content);

    public function writeLock($fileSave, $file);
}
