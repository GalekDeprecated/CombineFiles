<?php

namespace Galek\Utils\CombineFiles;

interface IFileManager {
    public function read();

    public function write();

    public function compare();
}
