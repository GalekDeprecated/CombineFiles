<?php

namespace Galek\Utils;

class Path
{
  
    public static function normalize($path)
    {
        $path = strtr($path, '\\', '/');
        $root = (strpos($path, '/') === 0) ? '/' : '';
        $pieces = explode('/', trim($path,'/'));
        $res = [];

        foreach ($pieces as $piece) {
            if ($piece === '.' || $piece === '') {
                continue;
            }

            if ($piece === '..') {
                array_pop($res);
            } else {
                array_push($res, $piece);
            }
        }
        return $root . implode('/', $res);
    }
}
