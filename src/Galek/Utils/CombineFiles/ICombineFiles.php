<?php

namespace Galek\Utils;

interface ICombineFiles
{
    /** @return string */
    public function getPath();

    /** @return array */
    public function getFiles();
}
