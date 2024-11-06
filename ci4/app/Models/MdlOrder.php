<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlOrder extends Model
{
    protected $table            = 'order';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id","kode","id_client","deadline","id_order_list","status","updated_at","deleted_at","created_at","link","nama_tim","logo_tim","brand"
];

protected bool $allowEmptyInserts = false;
protected bool $updateOnlyChanged = true;

protected array $casts = [];
protected array $castHandlers = [];

    // Dates
protected $useTimestamps = true;
protected $dateFormat    = 'datetime';
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';
protected $deletedField  = 'deleted_at';

    // Validation
protected $validationRules      = [];
protected $validationMessages   = [];
protected $skipValidation       = false;
protected $cleanValidationRules = true;

    // Callbacks
protected $allowCallbacks = true;
protected $beforeInsert   = [];
protected $afterInsert    = [];
protected $beforeUpdate   = [];
protected $afterUpdate    = [];
protected $beforeFind     = [];
protected $afterFind      = [];
protected $beforeDelete   = [];
protected $afterDelete    = [];

public function getOrderDetailById($orderId)
    {
        return $this->db->table('order')
            ->select('product.id as product_id,order.id as order_id, order.kode, CONCAT(client.nama_depan, " ", client.nama_belakang) as client_name, product.nama as product_name, order_list.price, order_list.status')
            ->join('client', 'client.id = order.id_client')  // Join ke tabel client, gabung nama depan dan nama belakang
            ->join('order_list', 'order_list.id_order = order.id')  // Join ke tabel order_list
            ->join('product', 'product.id = order_list.id_product') // Join ke tabel product
            ->where('order.id', $orderId)
            ->get()
            ->getResultArray();
    }
    public function getOrderDetail($orderId)
{
    return $this->db->table('order')
        ->select('product.id as product_id,order.id as order_id, order.kode, CONCAT(client.nama_depan, " ", client.nama_belakang) as client_name, order.logo_tim, product.nama as product_name, product.picture, order_list.price, order_list.status')
        ->join('client', 'client.id = order.id_client')  // Join ke tabel client untuk mengambil nama klien
        ->join('order_list', 'order_list.id_order = order.id')  // Join ke tabel order_list untuk detail pesanan
        ->join('product', 'product.id = order_list.id_product') // Join ke tabel product untuk mendapatkan informasi produk
        ->where('order.kode', $orderId)
        ->get()
        ->getResultArray();
}
    public function getOrderWithPlayers($orderId)
    {
        return $this->where('kode', $orderId)->first();
    }
}
