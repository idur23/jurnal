<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseService {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Database transaction helpers
     */
    protected function trans_begin() {
        $this->CI->db->trans_begin();
    }

    protected function trans_commit() {
        $this->CI->db->trans_commit();
    }

    protected function trans_rollback() {
        $this->CI->db->trans_rollback();
    }

    protected function trans_status() {
        return $this->CI->db->trans_status();
    }
}
