<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }
    
    public function index() {
        redirect('auth/register');
    }
    
    public function register() {
        $this->load->view('register');
    }
    
    public function check_email() {
        $email = $this->input->post('email');
        $exists = $this->User_model->check_email($email);
        echo json_encode(['exists' => $exists ? true : false]);
    }
    
    public function do_register() {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('user_type', 'User Type', 'required|in_list[employee,dealer]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
        } else {
            $data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'user_type' => $this->input->post('user_type')
            ];
            
            if ($this->User_model->register($data)) {
                echo json_encode(['success' => true, 'message' => 'Registration successful!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Registration failed!']);
            }
        }
    }
    
    public function login() {
        $this->load->view('login');
    }
    
    public function do_login() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
        } else {
            $user = $this->User_model->check_email($this->input->post('email'));
            
            if ($user && password_verify($this->input->post('password'), $user['password'])) {
                $this->session->set_userdata([
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'user_type' => $user['user_type'],
                    'logged_in' => true
                ]);
                
                if ($user['user_type'] === 'dealer' && $user['is_first_login']) {
                    echo json_encode(['success' => true, 'redirect' => base_url('dealer/profile')]);
                } else {
                    $redirect = $user['user_type'] === 'employee' ? base_url('employee/dealers') : base_url('dealer/dashboard');
                    echo json_encode(['success' => true, 'redirect' => $redirect]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid credentials!']);
            }
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
