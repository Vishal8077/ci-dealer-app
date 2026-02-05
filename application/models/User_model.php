<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function check_email($email) {
        return $this->db->where('email', $email)->get('users')->row_array();
    }
    
    public function register($data) {
        return $this->db->insert('users', $data);
    }
    
    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update('users', $data);
    }
    
    public function get_dealers($zip = '', $limit = 10, $offset = 0) {
        $this->db->where('user_type', 'dealer');
        if ($zip) {
            $this->db->like('zip_code', $zip);
        }
        $query = $this->db->limit($limit, $offset)->get('users');
        return $query->result_array();
    }
    
    public function count_dealers($zip = '') {
        $this->db->where('user_type', 'dealer');
        if ($zip) {
            $this->db->like('zip_code', $zip);
        }
        return $this->db->count_all_results('users');
    }
    
    public function get_user($id) {
        return $this->db->where('id', $id)->get('users')->row_array();
    }
}
