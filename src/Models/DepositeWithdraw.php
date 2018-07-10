<?php

namespace App\Models;

/**
 * Class DepositeWithdraw
 * @package App\Models
 */
class DepositeWithdraw extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'deposite_withdraw';

    /**
     * @var array
     */
    protected $columns = [ 'account_no', 'transaction_type', 'cheque_no', 'amount', 'verification_code', 'verified' ];

    /**
     * @var string
     */
    protected $primaryKey = 'transaction_id';
}
