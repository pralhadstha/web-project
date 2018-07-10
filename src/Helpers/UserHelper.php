<?php

namespace App\Helpers;

use App\Models\UserAccount;

/**
 * Class UserHelper
 * @package App\Helpers
 */
class UserHelper
{
    /**
     * @param null $userId
     * @return mixed
     */
    public static function getUser($userId = null)
    {
        if (!$userId) {
            $userId = isset($_SESSION['usrHash']) ? $_SESSION['usrHash'] : 0;
        }

        $user = new UserAccount();
        $usersInfo = $user->selectWhere("account_no = '{$userId}'");

        return $user->first($usersInfo);
    }

    /**
     * @return mixed
     */
    public static function getAllUsers()
    {
        $users = new UserAccount();

        return $users->all();
    }
}
