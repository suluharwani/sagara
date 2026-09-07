<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class Admin extends BaseController
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
    //   parent::__construct();
      $this->request = \Config\Services::request();
      $this->db      = \Config\Database::connect();
      $this->session = session();
      $this->bcrypt = new Bcrypt();
      $this->bcrypt_version = '2a';
      $this->uri = service('uri');
      helper('form');
      $this->form_validation = \Config\Services::validation();
      $this->userValidation = new \App\Controllers\LoginValidation();
      //if sesion habis
      //check login
      $check = new \App\Controllers\CheckAccess();
      $check->logged();
 
    }
    public function index()
    {
        // Date filter
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        
        // Get real statistics from database
        $orderModel = new \App\Models\MdlOrder();
        $clientModel = new \App\Models\MdlClient();
        $productModel = new \App\Models\MdlProduct();
        
        // Total stats (filtered by date)
        $data['totalOrders'] = $orderModel->where('deleted_at', null)->where('created_at >=', $startDate . ' 00:00:00')->where('created_at <=', $endDate . ' 23:59:59')->countAllResults();
        $data['completedOrders'] = $orderModel->where('deleted_at', null)->where('status', 2)->where('created_at >=', $startDate . ' 00:00:00')->where('created_at <=', $endDate . ' 23:59:59')->countAllResults();
        $data['processOrders'] = $orderModel->where('deleted_at', null)->where('status', 1)->where('created_at >=', $startDate . ' 00:00:00')->where('created_at <=', $endDate . ' 23:59:59')->countAllResults();
        $data['totalClients'] = $clientModel->where('deleted_at', null)->countAllResults();
        $data['totalProducts'] = $productModel->where('deleted_at', null)->countAllResults();
        
        // Get recent orders
        $data['recentOrders'] = $orderModel->where('deleted_at', null)->orderBy('created_at', 'DESC')->limit(10)->findAll();
        
        // Chart data - Daily orders based on date filter
        $data['chartLabels'] = [];
        $data['chartData'] = [];
        
        $daysDiff = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
        $daysDiff = min($daysDiff, 365); // Max 1 year
        
        for ($i = $daysDiff; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime($endDate . " -$i days"));
            $count = $orderModel->where('deleted_at', null)->where('DATE(created_at)', $date)->countAllResults();
            $data['chartLabels'][] = date('d M', strtotime($date));
            $data['chartData'][] = $count;
        }
        
        // Status distribution for pie chart
        $data['statusLabels'] = ['Baru', 'Proses', 'Selesai', 'Dikirim'];
        $statusCounts = [];
        foreach ([0, 1, 2, 3] as $status) {
            $statusCounts[] = $orderModel->where('deleted_at', null)->where('status', $status)->where('created_at >=', $startDate . ' 00:00:00')->where('created_at <=', $endDate . ' 23:59:59')->countAllResults();
        }
        $data['statusCounts'] = $statusCounts;
        
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        
        $data['content'] = view('admin/content/dashboard-admin', $data);
        return view('admin/layout', $data);
    }
      function test($table){
    $query = $this->db->query("SELECT * FROM $table");

    foreach ($query->getFieldNames() as $field) {
      echo '"'.$field.'",';
    }
}


    public function slider()
    {
        $model = new \App\Models\MdlSlider();
        $data['sliders'] = $model->where('deleted_at', null)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/slider', $data);
        return view('admin/layout', $data);
    }
    
    public function gallery()
    {
        $model = new \App\Models\MdlGallery();
        $data['galleries'] = $model->where('deleted_at', null)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/gallery', $data);
        return view('admin/layout', $data);
    }
    
    public function testimonial()
    {
        $model = new \App\Models\MdlTestimonial();
        $data['testimonials'] = $model->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/testimonial', $data);
        return view('admin/layout', $data);
    }
    
    public function blog()
    {
        $db = \Config\Database::connect();
        $data['posts'] = $db->table('content')->where('deleted_at', null)->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['content'] = view('admin/content/blog', $data);
        return view('admin/layout', $data);
    }
    
    public function informations()
    {
        $db = \Config\Database::connect();
        $data['informasi'] = $db->table('page')->where('deleted_at', null)->orderBy('created_at', 'DESC')->get()->getResultArray();
        $data['content'] = view('admin/content/informations', $data);
        return view('admin/layout', $data);
    }
    
    public function changelog()
    {
        $db = \Config\Database::connect();
        $data['changelogs'] = $db->table('changelog')->orderBy('created_at', 'DESC')->limit(100)->get()->getResultArray();
        $data['content'] = view('admin/content/changelog', $data);
        return view('admin/layout', $data);
    }
    
    public function settings()
    {
        $db = \Config\Database::connect();
        
        // Get current settings
        $settings = [];
        $query = $db->table('settings')->get();
        foreach ($query->getResult() as $row) {
            $settings[$row->key] = $row->value;
        }
        
        // Update settings if form submitted
        if ($this->request->getPost()) {
            $data = [
                'saturday_off' => $this->request->getPost('saturday_off') ?? '0',
                'sunday_off' => $this->request->getPost('sunday_off') ?? '0',
            ];
            
            foreach ($data as $key => $value) {
                $existing = $db->table('settings')->where('key', $key)->get()->getRow();
                if ($existing) {
                    $db->table('settings')->where('key', $key)->update(['value' => $value]);
                } else {
                    $db->table('settings')->insert(['key' => $key, 'value' => $value]);
                }
            }
            
            return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil disimpan');
        }
        
        $data['settings'] = $settings;
        $data['content'] = view('admin/content/settings', $data);
        return view('admin/layout', $data);
    }
    
    public function order()
    {
        $model = new \App\Models\MdlOrder();
        $data['orders'] = $model->where('deleted_at', null)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/order', $data);
        return view('admin/layout', $data);
    }
    
    public function user()
    {
        $model = new \App\Models\MdlUser();
        $data['users'] = $model->where('level !=', 3)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/user-admin', $data);
        return view('admin/layout', $data);
    }
    
    public function administrator()
    {
        $model = new \App\Models\MdlUser();
        $data['administrators'] = $model->where('level', 1)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/administrator-admin', $data);
        return view('admin/layout', $data);
    }
    
    public function client()
    {
        $model = new \App\Models\MdlClient();
        $data['clients'] = $model->where('deleted_at', null)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/client-admin', $data);
        return view('admin/layout', $data);
    }

    public function calendar()
    {
        $orderModel = new \App\Models\MdlOrder();
        $eventModel = new \App\Models\MdlCalendarEvent();
        $holidayModel = new \App\Models\MdlHoliday();
        $db = \Config\Database::connect();
        
        // Get settings
        $settings = [];
        $query = $db->table('settings')->get();
        foreach ($query->getResult() as $row) {
            $settings[$row->key] = $row->value;
        }
        
        // Get all orders with deadline
        $orders = $orderModel->where('deleted_at', null)->orderBy('deadline', 'ASC')->findAll();
        
        // Get all calendar events
        $events = $eventModel->where('deleted_at', null)->orderBy('event_date', 'ASC')->findAll();
        
        // Get all holidays
        $holidays = $holidayModel->where('deleted_at', null)->where('is_active', 1)->orderBy('holiday_date', 'ASC')->findAll();
        
        $data['orders'] = $orders;
        $data['events'] = $events;
        $data['holidays'] = $holidays;
        $data['settings'] = $settings;
        $data['content'] = view('admin/content/calendar', $data);
        return view('admin/layout', $data);
    }
    
    public function printCalendar()
    {
        $orderModel = new \App\Models\MdlOrder();
        $eventModel = new \App\Models\MdlCalendarEvent();
        $holidayModel = new \App\Models\MdlHoliday();
        $db = \Config\Database::connect();
        
        // Get settings
        $settings = [];
        $query = $db->table('settings')->get();
        foreach ($query->getResult() as $row) {
            $settings[$row->key] = $row->value;
        }
        
        // Get all orders with deadline
        $orders = $orderModel->where('deleted_at', null)->orderBy('deadline', 'ASC')->findAll();
        
        // Get all calendar events
        $events = $eventModel->where('deleted_at', null)->orderBy('event_date', 'ASC')->findAll();
        
        // Get all holidays
        $holidays = $holidayModel->where('deleted_at', null)->where('is_active', 1)->orderBy('holiday_date', 'ASC')->findAll();
        
        $data['orders'] = $orders;
        $data['events'] = $events;
        $data['holidays'] = $holidays;
        $data['settings'] = $settings;
        
        return view('admin/content/calendar-print', $data);
    }
    
    public function addCalendarEvent()
    {
        $eventModel = new \App\Models\MdlCalendarEvent();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'event_date' => $this->request->getPost('event_date'),
            'event_type' => $this->request->getPost('event_type'),
            'color' => $this->request->getPost('color'),
            'is_all_day' => $this->request->getPost('is_all_day') ?? 1,
        ];
        
        $eventModel->insert($data);
        return redirect()->to('admin/calendar')->with('success', 'Event berhasil ditambahkan');
    }
    
    public function deleteCalendarEvent($id)
    {
        $eventModel = new \App\Models\MdlCalendarEvent();
        $eventModel->delete($id);
        return redirect()->to('admin/calendar')->with('success', 'Event berhasil dihapus');
    }
}


