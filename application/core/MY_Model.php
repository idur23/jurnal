<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected $table = '';

    public function __construct() {
        parent::__construct();
    }

    public function get_all($order_by = 'id', $direction = 'DESC') {
        $this->db->order_by($order_by, $direction);
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function get_where($where = array()) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function get_row_where($where = array()) {
        return $this->db->get_where($this->table, $where)->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function insert_batch($data) {
        return $this->db->insert_batch($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function update_where($where, $data) {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function count_where($where = array()) {
        $this->db->where($where);
        return $this->db->count_all_results($this->table);
    }
}
