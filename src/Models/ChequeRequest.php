<?php

namespace App\Models;

/**
 * Class ChequeRequest
 * @package App\Models
 */
class ChequeRequest extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'cheque_request';

    /**
     * @var array
     */
    protected $columns = [ 'request_no', 'total_cheque_request', 'is_processed' ];

    /**
     * @var string
     */
    protected $primaryKey = 'request_no';
}
