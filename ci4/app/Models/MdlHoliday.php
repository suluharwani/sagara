<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlHoliday extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'holidays';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "title", "description", "holiday_date", "type", "is_active", "color", "created_at", "updated_at", "deleted_at"];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}