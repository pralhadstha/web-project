<?php

namespace App\Helpers;

/**
 * Class ConfigHelper
 * @package App\Helpers
 */
class ConfigHelper
{
    /**
     * @param $filename
     * @return string
     */
    public static function config($filename)
    {
        return DirectoryHelper::getRoot() . 'src/config/' . $filename;
    }
}
