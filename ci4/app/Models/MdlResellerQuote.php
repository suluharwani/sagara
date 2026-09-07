<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlResellerQuote extends Model
{
    protected $table = 'reseller_quotes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'reseller_id', 'quote_number', 'customer_name', 'customer_phone',
        'customer_address', 'notes', 'status', 'base_total', 'selling_total',
    ];
}
