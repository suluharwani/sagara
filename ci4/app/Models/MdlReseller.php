<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlReseller extends Model
{
    protected $table = 'resellers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'client_id', 'code', 'business_name', 'owner_name', 'whatsapp', 'city',
        'address', 'sales_channel', 'status', 'admin_note', 'approved_at',
    ];
}
