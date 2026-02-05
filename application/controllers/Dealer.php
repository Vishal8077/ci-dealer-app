<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }
    
    public function profile() {
        if ($this->session->userdata('user_type') !== 'dealer') {
            redirect('auth/login');
        }
        $this->load->view('dealer_profile');
    }
    
    public function update_profile() {
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|numeric|min_length[5]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
        } else {
            $data = [
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip_code' => $this->input->post('zip_code'),
                'is_first_login' => 0
            ];
            
            if ($this->User_model->update_user($this->session->userdata('user_id'), $data)) {
                echo json_encode(['success' => true, 'message' => 'Profile updated!', 'redirect' => base_url('dealer/dashboard')]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed!']);
            }
        }
    }
    
    public function dashboard() {
        if ($this->session->userdata('user_type') !== 'dealer') {
            redirect('auth/login');
        }
        $this->load->view('dealer_dashboard');
    }
    
    public function edit($id) {
        $data['dealer_id'] = $id;
        $this->load->view('edit_dealer', $data);
    }
    
    public function get_dealer($id) {
        $dealer = $this->User_model->get_user($id);
        echo json_encode(['success' => true, 'dealer' => $dealer]);
    }
    
    public function update($id) {
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|numeric|min_length[5]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
        } else {
            $data = [
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip_code' => $this->input->post('zip_code')
            ];
            
            if ($this->User_model->update_user($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Dealer updated!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed!']);
            }
        }
    }
}
