<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
    protected $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    public function get_user_by_identity($identity) {
        $this->db->select('users.*, roles.role_code, roles.role_name');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->group_start();
        $this->db->where('users.username', $identity);
        $this->db->or_where('users.email', $identity);
        $this->db->group_end();
        return $this->db->get($this->table)->row_array();
    }

    public function get_user_with_role($id) {
        $this->db->select('users.*, roles.role_code, roles.role_name');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->where('users.id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_all_users() {
        $this->db->select('users.*, roles.role_name, roles.role_code');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }
}
