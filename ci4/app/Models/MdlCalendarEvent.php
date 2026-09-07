<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlCalendarEvent extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'calendar_events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["id", "title", "description", "event_date", "event_type", "color", "is_all_day", "created_by", "created_at", "updated_at", "deleted_at"];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}