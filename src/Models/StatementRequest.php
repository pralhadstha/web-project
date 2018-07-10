<?php

namespace App\Models;


/**
 * Class StatementRequest
 * @package App\Models
 */
class StatementRequest extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'statement_request';

    /**
     * @var array
     */
    protected $columns = [ 'account_id', 'date_from', 'date_to', 'request_date', 'is_done' ];

    /**
     * @var string
     */
    protected $primaryKey = 'request_id';
}