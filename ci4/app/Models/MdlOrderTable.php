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
}
