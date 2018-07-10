<?php

namespace App\Helpers;


use App\Models\DepositeWithdraw;

/**
 * Class TransactionHelper
 * @package App\Helpers
 */
class TransactionHelper
{
    /**
     * @param $userId
     * @return mixed
     */
    public static function getUsersTransactions($userId)
    {
        $transaction = new DepositeWithdraw();

        return $transaction->selectWhere("account_no = '{$userId}'");
    }

    /**
     * @return string
     */
    public static function generateRandomCode()
    {
        $digits = 5;

        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }
}