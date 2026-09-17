<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends MY_Model {
    protected $table = 'activity_logs';

    public function __construct() {
        parent::__construct();
    }

    public function get_logs($limit = 100, $offset = 0) {
        $this->db->select('activity_logs.*, users.username, users.full_name, roles.role_name');
        $this->db->join('users', 'users.id = activity_logs.user_id', 'left');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->order_by('activity_logs.id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result_array();
    }
}
