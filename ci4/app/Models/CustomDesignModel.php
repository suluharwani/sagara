<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomDesignModel extends Model
{
    protected $table = 'custom_designs';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['kind', 'code', 'title', 'category', 'status', 'customer_name', 'customer_phone', 'admin_note', 'document', 'thumbnail', 'revision'];

    public const DESIGN_STATUSES = ['new' => 'Baru', 'review' => 'Ditinjau', 'revision' => 'Perlu revisi', 'approved' => 'Disetujui', 'archived' => 'Arsip'];
    public const TEMPLATE_STATUSES = ['draft' => 'Draft', 'published' => 'Publik', 'archived' => 'Arsip'];

    public function ready(): bool
    {
        return $this->db->tableExists($this->table);
    }
}
