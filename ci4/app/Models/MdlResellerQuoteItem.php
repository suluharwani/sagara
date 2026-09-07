<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlResellerQuoteItem extends Model
{
    protected $table = 'reseller_quote_items';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'quote_id', 'product_id', 'product_name', 'material', 'model_name',
        'color', 'size', 'quantity', 'base_price', 'selling_price', 'subtotal',
    ];
}
