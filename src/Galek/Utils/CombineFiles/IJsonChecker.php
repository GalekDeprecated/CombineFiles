<?php

namespace Galek\Utils;

interface IJsonChecker
{
    public function checkFiles($files, $lockFile);

    public function checkFile($file, $time);
}
