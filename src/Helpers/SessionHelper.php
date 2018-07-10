<?php

namespace App\Helpers;

/**
 * Class SessionHelper
 * @package App\Helpers
 */
class SessionHelper
{
    /**
     * @var int
     */
    protected $sessionTime = 60;

    /**
     * @param $data
     * @return bool
     */
    public static function setSessionData($data)
    {
        session_start();
        $_SESSION = array_merge($_SESSION, $data);
        session_write_close();
        return true;
    }

    public function setSession()
    {
        $this->trySessionTimeOut();
        $this->setSessionTimeOut();
    }

    /**
     * @return int
     */
    public function setSessionTimeOut()
    {
       return $_SESSION['timeout'] = time();
    }

    /**
     * @return bool
     */
    public function trySessionTimeOut()
    {
        if ($this->checkSessionLength() < time()) {
            if (!isset($_SESSION['rememberSession'])) {
                return $_SESSION['verifiedLogin'] = false;
            }
        }
    }

    /**
     * @return mixed
     */
    public function checkSessionLength()
    {
        return $_SESSION['timeout'] + ($this->sessionTime * 60);
    }
}