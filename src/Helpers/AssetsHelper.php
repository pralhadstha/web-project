<?php

namespace App\Helpers;

class AssetsHelper
{
    public static function getAssets($assetsType, $assetsName)
    {
        return DirectoryHelper::getPublicPath(). "assets/{$assetsType}/{$assetsName}";
    }
}