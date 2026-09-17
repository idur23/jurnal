<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Global header & security settings
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("X-Content-Type-Options: nosniff");

        // Load settings globally for all views
        $settings_raw = $this->db->get('system_settings')->result_array();
        $settings_map = array();
        foreach ($settings_raw as $s) {
            $settings_map[$s['setting_key']] = $s['setting_value'];
        }

        // Fetch Kamad info from DB for synchronization if not explicitly set
        $kamad = $this->db->select('guru.nama_lengkap, guru.nip, users.full_name')
            ->from('users')
            ->join('roles', 'roles.id = users.role_id')
            ->join('guru', 'guru.user_id = users.id', 'left')
            ->where('roles.role_code', 'kamad')
            ->get()->row_array();

        if (!empty($kamad)) {
            $settings_map['headmaster_name'] = (!empty($settings_map['report_signer_name']) && $settings_map['report_signer_name'] !== '')
                ? $settings_map['report_signer_name'] 
                : (!empty($kamad['nama_lengkap']) ? $kamad['nama_lengkap'] : $kamad['full_name']);
            
            $settings_map['headmaster_nip'] = (!empty($settings_map['report_signer_nip']) && $settings_map['report_signer_nip'] !== '')
                ? $settings_map['report_signer_nip'] 
                : (!empty($kamad['nip']) ? $kamad['nip'] : '001');
        } else {
            $settings_map['headmaster_name'] = !empty($settings_map['report_signer_name']) ? $settings_map['report_signer_name'] : 'M. Fakhrur Rozi, M.Pd';
            $settings_map['headmaster_nip'] = !empty($settings_map['report_signer_nip']) ? $settings_map['report_signer_nip'] : '001';
        }

        // Set printed_by from current logged-in user dynamically from database
        $user_session = $this->session->userdata('user_session');
        $printed_by = '';
        if (!empty($user_session['id'])) {
            $curr_user = $this->db->select('users.full_name, users.username, guru.nama_lengkap as guru_nama')
                ->from('users')
                ->join('guru', 'guru.user_id = users.id', 'left')
                ->where('users.id', $user_session['id'])
                ->get()->row_array();

            if (!empty($curr_user)) {
                $printed_by = !empty($curr_user['guru_nama']) 
                    ? $curr_user['guru_nama'] 
                    : (!empty($curr_user['full_name']) ? $curr_user['full_name'] : $curr_user['username']);
            }
        }

        if (empty($printed_by)) {
            $printed_by = !empty($user_session['full_name']) 
                ? $user_session['full_name'] 
                : (!empty($user_session['username']) ? $user_session['username'] : 'Staf Tata Usaha');
        }

        $settings_map['printed_by'] = $printed_by;

        $this->load->vars(array('_settings' => $settings_map, 'settings' => $settings_map));
    }
}

class Base_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        $this->auth_lib->check_access();
        $this->current_user = $this->auth_lib->get_user();
    }
}

class Admin_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        $this->auth_lib->check_access(array('admin', 'superadmin'));
        $this->current_user = $this->auth_lib->get_user();
    }
}

class Guru_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        $this->auth_lib->check_access(array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'));
        $this->current_user = $this->auth_lib->get_user();
    }
}

class Wali_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        $this->auth_lib->check_access(array('admin', 'superadmin', 'walikelas'));
        $this->current_user = $this->auth_lib->get_user();
    }
}

class Kamad_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        $this->auth_lib->check_access(array('admin', 'superadmin', 'kamad'));
        $this->current_user = $this->auth_lib->get_user();
    }
}

class Waka_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        $this->auth_lib->check_access(array('admin', 'superadmin', 'waka'));
        $this->current_user = $this->auth_lib->get_user();
    }
}

class Tentor_Controller extends MY_Controller {
    protected $current_user;

    public function __construct() {
        parent::__construct();
        if (is_cli()) {
            return;
        }
        if (!$this->auth_lib->is_logged_in()) {
            redirect('login');
            exit;
        }
        $this->current_user = $this->auth_lib->get_user();
        $role = isset($this->current_user['role_code']) ? $this->current_user['role_code'] : '';

        // Allowed if admin, superadmin, tentor role OR if user is linked in tentor table
        if (in_array($role, array('admin', 'superadmin', 'tentor'))) {
            return;
        }

        // Check if user is linked as a Tentor in DB
        $user_id = isset($this->current_user['id']) ? $this->current_user['id'] : 0;
        $this->load->model('mbf_model');
        $check_tentor = $this->mbf_model->get_tentor_by_user_id($user_id);

        if (!$check_tentor) {
            show_error('Akses ditolak: Anda tidak memiliki wewenang untuk mengakses modul Tentor MBF. Pastikan akun Anda telah didaftarkan sebagai Tentor MBF oleh Admin.', 403, '403 Forbidden');
            exit;
        }
    }
}



