<?php

namespace App\Helpers;

/**
 * Class DirectoryHelper
 * @package App\Helpers
 */
/**
 * Class DirectoryHelper
 * @package App\Helpers
 */
/**
 * Class DirectoryHelper
 * @package App\Helpers
 */
class DirectoryHelper
{
    /**
     * @return string
     */
    public static function getRoot()
    {
        return __DIR__ . '/../../';
    }

    /**
     * @return mixed
     */
    public static function getDomainRoot()
    {
        $config = include(ConfigHelper::config('app.php'));

        return $config['url'];
    }

    /**
     * @return string
     */
    public static function getPublicPath()
    {
        return self::getDomainRoot() . 'public/';
    }
}
