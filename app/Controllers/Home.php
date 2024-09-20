<?php

namespace App\Controllers;
use AllowDynamicProperties;
use App\Controllers\WarehouseController;
use Bcrypt\Bcrypt;

class Home extends BaseController
{
    protected $bcrypt;
    protected $userValidation;
    protected $bcrypt_version;
    protected $session;
    protected $db;
    protected $uri;
    protected $form_validation;
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->session = session();
        $this->bcrypt = new Bcrypt();
        $this->bcrypt_version = '2a';
        $this->uri = service('uri');
        helper('form');
        $this->form_validation = \Config\Services::validation();
        $this->userValidation = new \App\Controllers\LoginValidation();

        $check = new \App\Controllers\CheckAccess();
        $check->logged();

    }
    public function index(): string
    {
        $this->access('operator');
        $d = new WarehouseController();
        $data['group'] = 'Admin';
        $data['title'] = 'Dashboard';
        $data['content'] = view('admin/content/dashboard');
        return view('admin/index', $data);
    }
    function access($page)
    {
        $check = new \App\Controllers\CheckAccess();
        $check->access($_SESSION['auth']['id'], $page);
    }
    public function material()
    {
        $data['group'] = 'Material';
        $data['title'] = 'All Material';

        $data['content'] = view('admin/content/material');
        return view('admin/index', $data);
    }
    public function warehouse()
    {
        $data['group'] = 'Warehouse';
        $data['title'] = 'All Warehouse';

        $data['content'] = view('admin/content/warehouse');
        return view('admin/index', $data);
    }
    public function stock()
    {
        $data['group'] = 'Warehouse';
        $data['title'] = 'Warehouse Stock';
        $data['content'] = view('admin/content/warehouse_stock');
        return view('admin/index', $data);
    }
    public function production()
    {
        $data['group'] = 'Production';
        $data['title'] = 'All Production';
        $data['content'] = view('admin/content/production');
        return view('admin/index', $data);

    }
    public function design()
    {
        $data['group'] = 'Production';
        $data['title'] = 'Design';
        $data['content'] = view('admin/content/design');
        return view('admin/index', $data);

    }
    public function scrap()
    {
        $data['group'] = 'Production';
        $data['title'] = 'Scrap';
        $data['content'] = view('admin/content/scrap');
        return view('admin/index', $data);

    }
    public function product()
    {
        $data['group'] = 'Material';
        $data['title'] = 'Product';
        $data['content'] = view('admin/content/product');
        return view('admin/index', $data);

    }
    public function track_material()
    {
        $data['group'] = 'Material';
        $data['title'] = 'Track Material';
        $data['content'] = view('admin/content/track_material');
        return view('admin/index', $data);
    }
    public function scrap_management()
    {
        $data['group'] = 'Material';
        $data['title'] = 'Scrap Management';
        $data['content'] = view('admin/content/scrap_management');
        return view('admin/index', $data);
    }
    public function warehouse_report()
    {
        $data['group'] = 'Warehouse';
        $data['title'] = 'Report';
        $data['content'] = view('admin/content/warehouse_report');
        return view('admin/index', $data);
    }
    public function chagelog()
    {
        $data = [
            'group' => 'Warehouse',
            'title' => 'Warehouse Report',
            'content' => view('admin/content/chagelog'),
        ];

        return view('admin/index', $data);
    }
    public function purchase_order()
    {
        $data['group'] = 'Purchase';
        $data['title'] = 'All Purchase Order';
        $data['content'] = view('admin/content/purchase_order');
        return view('admin/index', $data);
    }
    public function work_order()
    {

        $data['group'] = 'Customer Order';
        $data['title'] = 'All Work Order';
        $data['content'] = view('admin/content/work_order');
        return view('admin/index', $data);
    }
    public function track_work_order()
    {
        $data['group'] = 'Customer Order';
        $data['title'] = 'Track Work Order';
        $data['content'] = view('admin/content/track_work_order');
        return view('admin/index', $data);
    }
    public function review_scrap_report()
    {
        $data['group'] = 'Scrap';
        $data['title'] = 'Review Scrap Report';
        $data['content'] = view('admin/content/review_scrap_report');
        return view('admin/index', $data);
    }
    public function user()
    {
        $data['group'] = 'User';
        $data['title'] = 'User';
        $data['content'] = view('admin/content/user');
        return view('admin/index', $data);
    }
    public function role()
    {
        $data['group'] = 'User';
        $data['title'] = 'Role';
        $data['content'] = view('admin/content/role');
        return view('admin/index', $data);
    }
    public function activitylog()
    {
        $data['group'] = 'User';
        $data['title'] = 'Activity log';
        $data['content'] = view('admin/content/activity_log');
        return view('admin/index', $data);
    }
    public function track_purchase_delivery()
    {
        $data['group'] = 'Purchase';
        $data['title'] = 'Track Purchase Delivery';
        $data['content'] = view('admin/content/track_purchase_delivery');
        return view('admin/index', $data);
    }

}
