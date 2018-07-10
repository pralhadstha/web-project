<?php

namespace App\Controllers;

/**
 * Class BaseController
 * @package App\Controllers
 */
class BaseController
{
    /**
     * @param $class
     * @return mixed
     */
    public function createInstance($class)
    {
        return new $class();
    }
}