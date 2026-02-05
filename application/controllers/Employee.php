<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_type') !== 'employee') {
            redirect('auth/login');
        }
    }
    
    public function dealers() {
        $this->load->view('employee_dealers');
    }
    
    public function get_dealers() {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        $zip = $this->input->get('zip_code');
        
        $dealers = $this->User_model->get_dealers($zip, $per_page, $offset);
        $total = $this->User_model->count_dealers($zip);
        
        echo json_encode([
            'success' => true,
            'dealers' => $dealers,
            'total' => $total,
            'page' => (int)$page,
            'totalPages' => ceil($total / $per_page)
        ]);
    }
}
