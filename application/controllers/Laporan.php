<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends Base_Controller {

    protected $laporanService;

    public function __construct() {
        parent::__construct();
        $this->laporanService = new LaporanService();
    }

    public function index() {
        $data['title'] = 'Laporan & Export Data Enterprise';
        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        // Fallback TP jika tidak ada yang aktif
        if (!$active_tp) {
            $active_tp = $this->db->order_by('id', 'DESC')->limit(1)->get('tahun_pelajaran')->row_array();
        }

        $tp_id = $active_tp ? $active_tp['id'] : 0;

        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
            $data['list_mapel'] = $this->master_model->get_mapel_by_guru($guru['id'], $tp_id);
            $data['list_kelas_jurnal'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $tp_id);

            if ($role == 'walikelas') {
                $wali_kelas = $this->master_model->get_kelas_by_wali_user_id($this->current_user['id']);
                if ($wali_kelas) {
                    $data['list_kelas_presensi'] = array($wali_kelas);
                } else {
                    $data['list_kelas_presensi'] = $this->master_model->get_kelas_by_guru_or_wali($guru['id'], $this->current_user['id'], $tp_id);
                }
            } else {
                $data['list_kelas_presensi'] = $this->master_model->get_kelas_by_guru($guru['id'], $tp_id);
            }
        } else {
            $data['list_mapel'] = $this->master_model->get_all_mapel();
            $data['list_kelas_jurnal'] = $this->master_model->get_all_kelas();
            $data['list_kelas_presensi'] = $this->master_model->get_all_kelas();
        }

        $data['list_guru'] = $this->master_model->get_all_guru();
        $data['list_tp'] = $this->master_model->get_all_tahun_pelajaran();

        // Authorized students list
        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru && $tp_id) {
            $data['list_siswa'] = $this->db->select('siswa.*, kelas.nama_kelas')
                ->join('kelas', 'kelas.id = siswa.kelas_id')
                ->group_start()
                    ->where('kelas.wali_kelas_id', $guru['id'])
                    ->or_where("siswa.kelas_id IN (SELECT DISTINCT kelas_id FROM jadwal_pelajaran WHERE guru_id = {$guru['id']} AND tahun_pelajaran_id = {$tp_id})")
                ->group_end()
                ->order_by('siswa.nama_lengkap', 'ASC')
                ->get('siswa')->result_array();
        } else {
            $data['list_siswa'] = $this->master_model->get_all_siswa();
        }

        $this->template->load('layout/main', 'laporan/index', $data);
    }

    public function print_jurnal() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $filters = array(
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        );

        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        $this->load->model('jurnal_model');
        $data['jurnal_list'] = $this->jurnal_model->get_jurnal_filtered($filters);
        $data['active_tp'] = $active_tp;

        $data['settings'] = $this->get_report_settings();

        $this->load->view('laporan/print_jurnal', $data);
    }

    public function jurnal_pdf() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $filters = array(
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        );

        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        $this->load->model('jurnal_model');
        $data['jurnal_list'] = $this->jurnal_model->get_jurnal_filtered($filters);
        $data['active_tp'] = $active_tp;
        $data['settings'] = $this->get_report_settings();
        $this->laporanService->render_pdf('laporan/pdf_jurnal', $data, 'laporan-jurnal-' . date('Ymd') . '.pdf', 'landscape');
    }

    public function jurnal_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $role = $this->current_user['role_code'];
        $guru = $this->master_model->get_guru_by_user_id($this->current_user['id']);

        $filters = array(
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        );

        if (in_array($role, array('guru', 'walikelas', 'waka')) && $guru) {
            $filters['guru_id'] = $guru['id'];
        }

        $this->laporanService->generate_jurnal_excel($filters, $active_tp);
    }

    public function presensi_pdf() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $this->load->model('presensi_model');

        $filters = array(
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'tahun_pelajaran_id' => $active_tp['id']
        );

        $data['siswa'] = $this->master_model->get_siswa_by_kelas($kelas_id);
        $data['rekap'] = $this->presensi_model->get_rekap_presensi($filters);
        $data['active_tp'] = $active_tp;
        $data['kelas'] = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        $data['mapel'] = $this->db->get_where('mata_pelajaran', array('id' => $mapel_id))->row_array();
        $data['title'] = 'Rekapitulasi Kehadiran Siswa';

        $data['settings'] = $this->get_report_settings();

        $this->laporanService->render_pdf('laporan/pdf_presensi', $data, 'rekap-kehadiran-' . date('Ymd') . '.pdf', 'landscape');
    }

    public function presensi_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();
        $this->load->model('presensi_model');

        $filters = array(
            'kelas_id' => $kelas_id,
            'mapel_id' => $mapel_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'tahun_pelajaran_id' => $active_tp['id']
        );

        $siswa = $this->master_model->get_siswa_by_kelas($kelas_id);
        $rekap = $this->presensi_model->get_rekap_presensi($filters);
        $kelas = $this->db->get_where('kelas', array('id' => $kelas_id))->row_array();
        $mapel = $this->db->get_where('mata_pelajaran', array('id' => $mapel_id))->row_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'REKAPITULASI PRESENSI KEHADIRAN SISWA');
        $sheet->setCellValue('A2', 'Kelas: ' . ($kelas['nama_kelas'] ?? '') . ' | Mapel: ' . ($mapel['nama_mapel'] ?? ''));
        $sheet->setCellValue('A3', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
        $sheet->setCellValue('A4', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'NIS', 'Nama Siswa', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Terlambat', 'Dispen', 'Persentase Kehadiran');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '6', $h);
            $sheet->getStyle($col . '6')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 7;
        $no = 1;
        foreach ($siswa as $s) {
            $s_id = $s['id'];
            $hadir = isset($rekap[$s_id]['Hadir']) ? $rekap[$s_id]['Hadir'] : 0;
            $sakit = isset($rekap[$s_id]['Sakit']) ? $rekap[$s_id]['Sakit'] : 0;
            $izin = isset($rekap[$s_id]['Izin']) ? $rekap[$s_id]['Izin'] : 0;
            $alpa = isset($rekap[$s_id]['Alpa']) ? $rekap[$s_id]['Alpa'] : 0;
            $terlambat = isset($rekap[$s_id]['Terlambat']) ? $rekap[$s_id]['Terlambat'] : 0;
            $dispen = isset($rekap[$s_id]['Dispen']) ? $rekap[$s_id]['Dispen'] : 0;

            $total = $hadir + $sakit + $izin + $alpa + $terlambat + $dispen;
            $percent = ($total > 0) ? round((($hadir + $terlambat + $dispen) / $total) * 100, 1) . '%' : '100%';

            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValueExplicit('B' . $row_index, $s['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row_index, $s['nama_lengkap']);
            $sheet->setCellValue('D' . $row_index, $hadir);
            $sheet->setCellValue('E' . $row_index, $sakit);
            $sheet->setCellValue('F' . $row_index, $izin);
            $sheet->setCellValue('G' . $row_index, $alpa);
            $sheet->setCellValue('H' . $row_index, $terlambat);
            $sheet->setCellValue('I' . $row_index, $dispen);
            $sheet->setCellValue('J' . $row_index, $percent);
            $row_index++;
        }

        foreach (range('A', 'J') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Rekap_Presensi_' . str_replace(' ', '_', $kelas['nama_kelas'] ?? 'Kelas') . '_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function presensikelas_pdf() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $guru_id = $this->input->get('guru_id', TRUE);
        $status_pembelajaran = $this->input->get('status_pembelajaran', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $this->db->select('presensi_kelas.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, ruangan.nama_ruangan');
        $this->db->from('presensi_kelas');
        $this->db->join('kelas', 'kelas.id = presensi_kelas.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = presensi_kelas.mapel_id');
        $this->db->join('guru', 'guru.id = presensi_kelas.guru_id');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');

        if ($kelas_id) $this->db->where('presensi_kelas.kelas_id', $kelas_id);
        if ($mapel_id) $this->db->where('presensi_kelas.mapel_id', $mapel_id);
        if ($guru_id) $this->db->where('presensi_kelas.guru_id', $guru_id);
        if ($status_pembelajaran) $this->db->where('presensi_kelas.status_pembelajaran', $status_pembelajaran);
        $this->db->where('jurnal_guru.tahun_pelajaran_id', $active_tp['id']);
        if ($tanggal_mulai) $this->db->where('presensi_kelas.tanggal >=', $tanggal_mulai);
        if ($tanggal_selesai) $this->db->where('presensi_kelas.tanggal <=', $tanggal_selesai);

        $this->db->order_by('presensi_kelas.tanggal', 'DESC');
        $logs = $this->db->get()->result_array();

        $data['active_tp'] = $active_tp;
        $data['logs'] = $logs;
        $data['title'] = 'Laporan Kehadiran Kelas & Kegiatan KBM';

        $data['settings'] = $this->get_report_settings();

        $this->laporanService->render_pdf('laporan/pdf_presensikelas', $data, 'laporan-kehadiran-kelas-' . date('Ymd') . '.pdf', 'landscape');
    }

    public function presensikelas_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $mapel_id = $this->input->get('mapel_id', TRUE);
        $guru_id = $this->input->get('guru_id', TRUE);
        $status_pembelajaran = $this->input->get('status_pembelajaran', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $this->master_model->get_active_tahun_pelajaran();

        $this->db->select('presensi_kelas.*, kelas.nama_kelas, mata_pelajaran.nama_mapel, guru.nama_lengkap as nama_guru, ruangan.nama_ruangan');
        $this->db->from('presensi_kelas');
        $this->db->join('kelas', 'kelas.id = presensi_kelas.kelas_id');
        $this->db->join('mata_pelajaran', 'mata_pelajaran.id = presensi_kelas.mapel_id');
        $this->db->join('guru', 'guru.id = presensi_kelas.guru_id');
        $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id');
        $this->db->join('ruangan', 'ruangan.id = presensi_kelas.ruangan_id', 'left');

        if ($kelas_id) $this->db->where('presensi_kelas.kelas_id', $kelas_id);
        if ($mapel_id) $this->db->where('presensi_kelas.mapel_id', $mapel_id);
        if ($guru_id) $this->db->where('presensi_kelas.guru_id', $guru_id);
        if ($status_pembelajaran) $this->db->where('presensi_kelas.status_pembelajaran', $status_pembelajaran);
        $this->db->where('jurnal_guru.tahun_pelajaran_id', $active_tp['id']);
        if ($tanggal_mulai) $this->db->where('presensi_kelas.tanggal >=', $tanggal_mulai);
        if ($tanggal_selesai) $this->db->where('presensi_kelas.tanggal <=', $tanggal_selesai);

        $this->db->order_by('presensi_kelas.tanggal', 'DESC');
        $logs = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN REKAPITULASI KEHADIRAN KELAS & WORKFLOW KBM');
        $sheet->setCellValue('A2', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'Tanggal', 'Jam KBM', 'Kelas', 'Mata Pelajaran', 'Guru Pengampu', 'Ruangan', 'Pertemuan Ke', 'Status KBM', 'Catatan Guru / Alasan');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 6;
        $no = 1;
        foreach ($logs as $l) {
            $time_slot = substr($l['jam_mulai'], 0, 5) . ' - ' . substr($l['jam_selesai'], 0, 5);
            $catatan = ($l['status_pembelajaran'] == 'Tidak Terlaksana') ? 'Alasan: ' . $l['alasan_tidak_terlaksana'] : ($l['catatan_guru'] ? $l['catatan_guru'] : '-');

            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValue('B' . $row_index, date('d-m-Y', strtotime($l['tanggal'])));
            $sheet->setCellValue('C' . $row_index, $time_slot);
            $sheet->setCellValue('D' . $row_index, $l['nama_kelas']);
            $sheet->setCellValue('E' . $row_index, $l['nama_mapel']);
            $sheet->setCellValue('F' . $row_index, $l['nama_guru']);
            $sheet->setCellValue('G' . $row_index, $l['nama_ruangan'] ? $l['nama_ruangan'] : '-');
            $sheet->setCellValue('H' . $row_index, $l['pertemuan_ke']);
            $sheet->setCellValue('I' . $row_index, $l['status_pembelajaran']);
            $sheet->setCellValue('J' . $row_index, $catatan);
            $row_index++;
        }

        foreach (range('A', 'J') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Kehadiran_Kelas_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function penanganan_pdf() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $siswa_id = $this->input->get('siswa_id', TRUE);
        $kategori = $this->input->get('kategori', TRUE);
        $tp_id = $this->input->get('tahun_pelajaran_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();

        // Fallback: if no active_tp found, return error message
        if (!$active_tp) {
            show_error('Tidak ada Tahun Pelajaran aktif. Silakan aktifkan Tahun Pelajaran terlebih dahulu pada menu Master.', 400, 'Tahun Pelajaran Tidak Ditemukan');
            return;
        }

        $selected_kelas = $kelas_id ? $this->db->get_where('kelas', array('id' => $kelas_id))->row_array() : NULL;
        $selected_siswa = $siswa_id ? $this->db->get_where('siswa', array('id' => $siswa_id))->row_array() : NULL;

        $wali_kelas = NULL;
        if ($selected_kelas && !empty($selected_kelas['wali_kelas_id'])) {
            $wali_kelas = $this->db->get_where('guru', array('id' => $selected_kelas['wali_kelas_id']))->row_array();
        } else {
            $wali_kelas = $this->master_model->get_guru_by_user_id($this->current_user['id']);
        }

        // Gunakan LEFT JOIN untuk kelas agar data tetap tampil
        // meski ada inkonsistensi kelas_id pada penanganan_siswa
        $this->db->select('penanganan_siswa.*, siswa.nis, siswa.nama_lengkap as nama_siswa, kelas.nama_kelas, guru.nama_lengkap as nama_guru');
        $this->db->from('penanganan_siswa');
        $this->db->join('siswa', 'siswa.id = penanganan_siswa.siswa_id', 'left');
        $this->db->join('kelas', 'kelas.id = penanganan_siswa.kelas_id', 'left');
        $this->db->join('guru', 'guru.id = penanganan_siswa.wali_id', 'left');

        if ($kelas_id) $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        if ($siswa_id) $this->db->where('penanganan_siswa.siswa_id', $siswa_id);
        if ($kategori) $this->db->where('penanganan_siswa.kategori', $kategori);
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $active_tp['id']);
        if ($tanggal_mulai) $this->db->where('penanganan_siswa.tanggal >=', $tanggal_mulai);
        if ($tanggal_selesai) $this->db->where('penanganan_siswa.tanggal <=', $tanggal_selesai);

        $this->db->order_by('penanganan_siswa.tanggal', 'DESC');
        $cases = $this->db->get()->result_array();

        $data['active_tp'] = $active_tp;
        $data['selected_kelas'] = $selected_kelas;
        $data['selected_siswa'] = $selected_siswa;
        $data['wali_kelas'] = $wali_kelas;
        $data['cases'] = $cases;
        $data['title'] = 'Jurnal Penanganan Siswa';

        $data['settings'] = $this->get_report_settings();

        $this->laporanService->render_pdf('laporan/pdf_penanganan', $data, 'laporan-penanganan-' . date('Ymd') . '.pdf', 'landscape');
    }

    public function penanganan_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $siswa_id = $this->input->get('siswa_id', TRUE);
        $kategori = $this->input->get('kategori', TRUE);
        $tp_id = $this->input->get('tahun_pelajaran_id', TRUE);
        $tanggal_mulai = $this->input->get('tanggal_mulai', TRUE);
        $tanggal_selesai = $this->input->get('tanggal_selesai', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();

        if (!$active_tp) {
            show_error('Tidak ada Tahun Pelajaran aktif.', 400, 'Tahun Pelajaran Tidak Ditemukan');
            return;
        }

        // Gunakan LEFT JOIN agar data tetap muncul meski ada inkonsistensi
        $this->db->select('penanganan_siswa.*, siswa.nis, siswa.nama_lengkap as nama_siswa, kelas.nama_kelas, guru.nama_lengkap as nama_guru');
        $this->db->from('penanganan_siswa');
        $this->db->join('siswa', 'siswa.id = penanganan_siswa.siswa_id', 'left');
        $this->db->join('kelas', 'kelas.id = penanganan_siswa.kelas_id', 'left');
        $this->db->join('guru', 'guru.id = penanganan_siswa.wali_id', 'left');

        if ($kelas_id) $this->db->where('penanganan_siswa.kelas_id', $kelas_id);
        if ($siswa_id) $this->db->where('penanganan_siswa.siswa_id', $siswa_id);
        if ($kategori) $this->db->where('penanganan_siswa.kategori', $kategori);
        $this->db->where('penanganan_siswa.tahun_pelajaran_id', $active_tp['id']);
        if ($tanggal_mulai) $this->db->where('penanganan_siswa.tanggal >=', $tanggal_mulai);
        if ($tanggal_selesai) $this->db->where('penanganan_siswa.tanggal <=', $tanggal_selesai);

        $this->db->order_by('penanganan_siswa.tanggal', 'DESC');
        $cases = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN JURNAL PENANGANAN & PEMBINAAN SISWA');
        $sheet->setCellValue('A2', 'Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'Tanggal', 'NIS', 'Nama Siswa', 'Kelas', 'Kategori', 'Permasalahan', 'Tindakan', 'Hasil', 'RTL', 'Status', 'Petugas');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 6;
        $no = 1;
        foreach ($cases as $c) {
            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValue('B' . $row_index, date('d-m-Y', strtotime($c['tanggal'])));
            $sheet->setCellValueExplicit('C' . $row_index, $c['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row_index, $c['nama_siswa']);
            $sheet->setCellValue('E' . $row_index, $c['nama_kelas']);
            $sheet->setCellValue('F' . $row_index, $c['kategori']);
            $sheet->setCellValue('G' . $row_index, $c['permasalahan']);
            $sheet->setCellValue('H' . $row_index, $c['tindakan'] ? $c['tindakan'] : '-');
            $sheet->setCellValue('I' . $row_index, $c['hasil'] ? $c['hasil'] : '-');
            $sheet->setCellValue('J' . $row_index, $c['rencana_tindak_lanjut'] ? $c['rencana_tindak_lanjut'] : '-');
            $sheet->setCellValue('K' . $row_index, $c['status']);
            $sheet->setCellValue('L' . $row_index, $c['nama_guru']);
            $row_index++;
        }

        foreach (range('A', 'L') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Penanganan_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    public function pembinaan_pdf() {
        return $this->penanganan_pdf();
    }

    public function pembinaan_excel() {
        return $this->penanganan_excel();
    }

    public function perkembangan_pdf() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $siswa_id = $this->input->get('siswa_id', TRUE);
        $tp_id = $this->input->get('tahun_pelajaran_id', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();

        // Fallback: jika tidak ada tahun pelajaran aktif, kembalikan error yang jelas
        if (!$active_tp) {
            show_error('Tidak ada Tahun Pelajaran aktif. Silakan aktifkan Tahun Pelajaran terlebih dahulu pada menu Master.', 400, 'Tahun Pelajaran Tidak Ditemukan');
            return;
        }

        if (!$kelas_id && $siswa_id) {
            $siswa_row = $this->db->get_where('siswa', array('id' => $siswa_id))->row_array();
            if ($siswa_row) {
                $kelas_id = $siswa_row['kelas_id'];
            }
        }

        $kelas = $kelas_id ? $this->db->get_where('kelas', array('id' => $kelas_id))->row_array() : NULL;
        if (!$kelas) {
            $this->session->set_flashdata('error', 'Silakan pilih kelas terlebih dahulu.');
            redirect('laporan');
            return;
        }

        if ($siswa_id) {
            $siswa_list = $this->db->where('id', $siswa_id)->get('siswa')->result_array();
        } else {
            $siswa_list = $this->db->where('kelas_id', $kelas_id)->where('status_aktif', 1)->order_by('nama_lengkap', 'ASC')->get('siswa')->result_array();
        }

        $this->load->model('perkembangan_model');
        $this->load->model('presensi_model');
        $this->load->model('penilaian_model');

        $report_data = array();

        foreach ($siswa_list as $s) {
            // Ambil detail siswa dengan wali kelas
            $s_details = $this->db
                ->select('siswa.*, kelas.nama_kelas, guru.nama_lengkap as nama_wali, guru.nip as nip_wali')
                ->join('kelas', 'kelas.id = siswa.kelas_id')
                ->join('guru', 'guru.id = kelas.wali_kelas_id', 'left')
                ->where('siswa.id', $s['id'])
                ->get('siswa')->row_array();

            $catatan_mapel = $this->perkembangan_model->get_perkembangan_grouped_by_siswa($s['id'], $active_tp['id']);
            $rekap = $this->perkembangan_model->get_rekap_by_siswa($s['id'], $active_tp['id']);

            // Rerata nilai per mapel
            $nilai_summary = $this->db
                ->select('mata_pelajaran.nama_mapel, AVG(penilaian_siswa.nilai) as rata_nilai')
                ->join('mata_pelajaran', 'mata_pelajaran.id = penilaian_siswa.mapel_id')
                ->where('penilaian_siswa.siswa_id', $s['id'])
                ->where('penilaian_siswa.tahun_pelajaran_id', $active_tp['id'])
                ->group_by('penilaian_siswa.mapel_id')
                ->get('penilaian_siswa')->result_array();

            $rata_nilai_total = 0;
            if (!empty($nilai_summary)) {
                $sum_nilai = 0;
                foreach ($nilai_summary as $ns) {
                    $sum_nilai += (float)$ns['rata_nilai'];
                }
                $rata_nilai_total = $sum_nilai / count($nilai_summary);
            }

            // Rekapitulasi presensi
            $presensi_raw = $this->db
                ->select('presensi_siswa.status, COUNT(*) as count')
                ->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id')
                ->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id')
                ->where('presensi_siswa.siswa_id', $s['id'])
                ->where('jurnal_guru.tahun_pelajaran_id', $active_tp['id'])
                ->group_by('presensi_siswa.status')
                ->get('presensi_siswa')->result_array();

            $presensi_map = array('Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpa' => 0, 'Dispen' => 0);
            foreach ($presensi_raw as $pr) {
                $status = $pr['status'];
                if ($status == 'Alpha') $status = 'Alpa';
                if (isset($presensi_map[$status])) {
                    $presensi_map[$status] = (int)$pr['count'];
                }
            }

            // Rerata aspek perkembangan
            $aspek_raw = $this->db
                ->select('AVG(perilaku) as avg_perilaku, AVG(keaktifan) as avg_keaktifan, AVG(kedisiplinan) as avg_kedisiplinan, AVG(motivasi) as avg_motivasi')
                ->where('siswa_id', $s['id'])
                ->where('tahun_pelajaran_id', $active_tp['id'])
                ->get('perkembangan_siswa')->row_array();

            $aspek_avg = array(
                'perilaku'     => (float)($aspek_raw['avg_perilaku'] ?? 3.0),
                'keaktifan'    => (float)($aspek_raw['avg_keaktifan'] ?? 3.0),
                'kedisiplinan' => (float)($aspek_raw['avg_kedisiplinan'] ?? 3.0),
                'motivasi'     => (float)($aspek_raw['avg_motivasi'] ?? 3.0)
            );

            $report_data[$s['id']] = array(
                'siswa'          => $s_details,
                'catatan_mapel'  => $catatan_mapel,
                'rekap'          => $rekap,
                'nilai_summary'  => $nilai_summary,
                'rata_nilai_total' => $rata_nilai_total,
                'presensi'       => $presensi_map,
                'aspek_avg'      => $aspek_avg
            );
        }

        $data['report_data'] = $report_data;
        $data['active_tp'] = $active_tp;
        $data['title'] = 'Rapor Perkembangan Diri Siswa';

        $data['settings'] = $this->get_report_settings();

        $this->laporanService->render_pdf('laporan/pdf_perkembangan', $data, 'rapor-perkembangan-' . date('Ymd') . '.pdf', 'portrait');
    }

    public function perkembangan_excel() {
        $kelas_id = $this->input->get('kelas_id', TRUE);
        $siswa_id = $this->input->get('siswa_id', TRUE);
        $tp_id = $this->input->get('tahun_pelajaran_id', TRUE);

        $active_tp = $tp_id ? $this->db->get_where('tahun_pelajaran', array('id' => $tp_id))->row_array() : $this->master_model->get_active_tahun_pelajaran();

        if (!$active_tp) {
            show_error('Tidak ada Tahun Pelajaran aktif.', 400, 'Tahun Pelajaran Tidak Ditemukan');
            return;
        }

        if (!$kelas_id && $siswa_id) {
            $siswa_row = $this->db->get_where('siswa', array('id' => $siswa_id))->row_array();
            if ($siswa_row) {
                $kelas_id = $siswa_row['kelas_id'];
            }
        }

        $kelas = $kelas_id ? $this->db->get_where('kelas', array('id' => $kelas_id))->row_array() : NULL;
        if (!$kelas) {
            $this->session->set_flashdata('error', 'Silakan pilih kelas terlebih dahulu.');
            redirect('laporan');
            return;
        }

        if ($siswa_id) {
            $siswa_list = $this->db->where('id', $siswa_id)->get('siswa')->result_array();
        } else {
            $siswa_list = $this->db->where('kelas_id', $kelas_id)->where('status_aktif', 1)->order_by('nama_lengkap', 'ASC')->get('siswa')->result_array();
        }

        $this->load->model('perkembangan_model');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'LAPORAN REKAPITULASI PERKEMBANGAN DIRI SISWA');
        $sheet->setCellValue('A2', 'Kelas: ' . ($kelas['nama_kelas'] ?? '') . ' | Tahun Pelajaran: ' . $active_tp['tahun'] . ' (' . $active_tp['semester'] . ')');
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i'));

        $headers = array('No', 'NIS', 'Nama Siswa', 'Rerata Sikap', 'Rerata Keaktifan', 'Rerata Kedisiplinan', 'Rerata Motivasi', 'Rerata Akademik', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Dispen', 'Status Evaluasi');
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '5', $h);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $col++;
        }

        $row_index = 6;
        $no = 1;
        foreach ($siswa_list as $s) {
            $this->db->select('AVG(perilaku) as avg_perilaku, AVG(keaktifan) as avg_keaktifan, AVG(kedisiplinan) as avg_kedisiplinan, AVG(motivasi) as avg_motivasi');
            $this->db->from('perkembangan_siswa');
            $this->db->where('siswa_id', $s['id']);
            $this->db->where('tahun_pelajaran_id', $active_tp['id']);
            $aspek_raw = $this->db->get()->row_array();

            $this->db->select('AVG(nilai) as avg_nilai');
            $this->db->from('penilaian_siswa');
            $this->db->where('siswa_id', $s['id']);
            $this->db->where('tahun_pelajaran_id', $active_tp['id']);
            $nilai_raw = $this->db->get()->row_array();

            $this->db->select('presensi_siswa.status, COUNT(*) as count');
            $this->db->from('presensi_siswa');
            $this->db->join('presensi_kelas', 'presensi_kelas.id = presensi_siswa.presensi_kelas_id');
            $this->db->join('jurnal_guru', 'jurnal_guru.id = presensi_kelas.jurnal_id');
            $this->db->where('presensi_siswa.siswa_id', $s['id']);
            $this->db->where('jurnal_guru.tahun_pelajaran_id', $active_tp['id']);
            $this->db->group_by('presensi_siswa.status');
            $presensi_raw = $this->db->get()->result_array();

            $presensi_map = array('Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpa' => 0, 'Dispen' => 0);
            foreach ($presensi_raw as $pr) {
                $status = $pr['status'];
                if ($status == 'Alpha') $status = 'Alpa';
                if (isset($presensi_map[$status])) {
                    $presensi_map[$status] = (int)$pr['count'];
                }
            }

            $rekap = $this->perkembangan_model->get_rekap_by_siswa($s['id'], $active_tp['id']);
            $status_perkembangan = $rekap ? ($rekap['status_perkembangan'] ?? '-') : '-';

            $sheet->setCellValue('A' . $row_index, $no++);
            $sheet->setCellValueExplicit('B' . $row_index, $s['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row_index, $s['nama_lengkap']);
            $sheet->setCellValue('D' . $row_index, number_format((float)($aspek_raw['avg_perilaku'] ?? 0), 2));
            $sheet->setCellValue('E' . $row_index, number_format((float)($aspek_raw['avg_keaktifan'] ?? 0), 2));
            $sheet->setCellValue('F' . $row_index, number_format((float)($aspek_raw['avg_kedisiplinan'] ?? 0), 2));
            $sheet->setCellValue('G' . $row_index, number_format((float)($aspek_raw['avg_motivasi'] ?? 0), 2));
            $sheet->setCellValue('H' . $row_index, number_format((float)($nilai_raw['avg_nilai'] ?? 0), 2));
            $sheet->setCellValue('I' . $row_index, $presensi_map['Hadir']);
            $sheet->setCellValue('J' . $row_index, $presensi_map['Sakit']);
            $sheet->setCellValue('K' . $row_index, $presensi_map['Izin']);
            $sheet->setCellValue('L' . $row_index, $presensi_map['Alpa']);
            $sheet->setCellValue('M' . $row_index, $presensi_map['Dispen']);
            $sheet->setCellValue('N' . $row_index, $status_perkembangan);
            $row_index++;
        }

        foreach (range('A', 'N') as $c_col) {
            $sheet->getColumnDimension($c_col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Rekap_Perkembangan_' . str_replace(' ', '_', $kelas['nama_kelas'] ?? 'Kelas') . '_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    private function get_report_settings() {
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

        return $settings_map;
    }
}
