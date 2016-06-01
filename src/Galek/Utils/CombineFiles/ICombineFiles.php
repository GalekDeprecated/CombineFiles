<?php

namespace Galek\Utils;

interface ICombineFiles
{
    /** @return string */
    public function getPath();

    /** @return array */
    public function getFiles();

    /** @return array */
    public function addFiles($files);

    /** @return string */
    public function addFile($file);

}
