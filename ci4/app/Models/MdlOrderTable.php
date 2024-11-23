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
    $builder->select('order_list.price as price,
        ordertable.*,ordertable.nama as nama_player, 
        product.*,product.nama as nama_product ,product.id as product_id,
        size.kategori as size_category, 
        size.ukuran as size_value
    ');

    $builder->join('product', 'ordertable.id_product = product.id', 'left'); // Join ke tabel product
    $builder->join('size', 'size.id = ordertable.id_size', 'left'); // Join ke tabel size
    $builder->join('order_list', 'order_list.id_product = product.id', 'left'); // Join ke tabel size
    $builder->join('order', 'order_list.id_order = order.id', 'left'); // Join ke tabel size

    $builder->where('order.kode', $orderId);
    // $builder->where('order_list.id_order', $orderId);

    // Tambahkan pengurutan sesuai role, size, dan nomor jersey
    $builder->orderBy('ordertable.keterangan', 'ASC'); // Urutkan berdasarkan role
    $builder->orderBy('size.kategori', 'ASC'); // Urutkan berdasarkan kategori size
    $builder->orderBy('size.ukuran', 'ASC'); // Urutkan berdasarkan ukuran
    $builder->orderBy('ordertable.nomor_punggung', 'ASC'); // Urutkan berdasarkan nomor punggung

    return $builder->get()->getResultArray();
}
    
}
