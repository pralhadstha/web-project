<?php

namespace App\Models;

/**
 * Class UserAccount
 * @package App\Models
 */
class UserAccount extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'users_account';

    /**
     * @var array
     */
    protected $columns = [
        'username', 'password', 'email', 'account_name', 'address', 'mobile_number',
        'users_ip', 'active', 'verification_code'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'account_no';
}