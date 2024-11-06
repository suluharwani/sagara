<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlOrderTable extends Model
{
    protected $table = 'ordertable';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_order','id_product','id_size', 'nama', 'ukuran', 'nomor_punggung', 'keterangan'];
    protected $useTimestamps = true;

     public function getOrdersWithParent($id_order = null)
    {
        $builder = $this->db->table('ordertable');
        $builder->select('ordertable.*, order.kode');
        $builder->join('order', 'order.id = ordertable.id_order');
        
        if ($id_order) {
            $builder->where('ordertable.id_order', $id_order);
        }

        return $builder->get()->getResultArray(); // Mengembalikan array hasil join
    }

        public function getPlayersByOrderId($orderId)
    {
        $builder = $this->db->table('ordertable');
        $builder->select('
            ordertable.*,
            size.kategori as size_category,
            size.ukuran as size_value
        ');

        $builder->join('size', 'size.id = ordertable.id_size', 'left'); // Left join to include size details
        
        $builder->where('ordertable.id_order', $orderId);
        
        return $builder->get()->getResultArray();
    }
}
