<?php
$role = isset($_user['role_code']) ? $_user['role_code'] : '';
$uri_segment = $this->uri->segment(1);
$sub_segment = $this->uri->segment(2);
?>
<!-- Sidebar / Navbar -->
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-2 px-sm-3">
    <!-- Toggler Button for Mobile -->
    <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <i class="ti ti-menu-2 fs-2"></i>
    </button>
    
    <!-- Aesthetic Branding Header -->
    <div class="brand-wrapper py-2 py-lg-3 my-0 my-lg-1 border-bottom-lg border-secondary border-opacity-25 me-auto me-lg-0">
      <a href="<?= base_url('dashboard') ?>" class="d-flex align-items-center text-decoration-none">
        <?php if (!empty($_settings['app_logo']) && file_exists('./' . $_settings['app_logo'])): ?>
          <img src="<?= base_url($_settings['app_logo']) ?>?v=<?= time() ?>" class="me-2 rounded-3 flex-shrink-0 shadow-lg" style="width: 40px; height: 40px; object-fit: cover;">
        <?php else: ?>
          <div class="avatar avatar-md rounded-3 me-2 text-white shadow-lg flex-shrink-0" style="background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);">
            <i class="ti ti-notebook fs-2"></i>
          </div>
        <?php endif; ?>
        <div class="overflow-hidden">
          <div class="fw-bold text-white fs-3 lh-sm" style="max-width: 150px; word-break: break-word;" title="<?= html_escape($_settings['app_name'] ?? 'Jurnal Guru') ?>">
            <?= html_escape($_settings['app_name'] ?? 'Jurnal Guru') ?>
          </div>
        </div>
      </a>
    </div>

    <!-- Mobile Action Buttons (Profile Avatar Menu) -->
    <div class="navbar-nav flex-row d-lg-none ms-auto align-items-center gap-2">

      <!-- Mobile User Profile -->
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm bg-primary text-white fw-bold shadow-sm">
            <?= strtoupper(substr($_user['full_name'] ?? 'U', 0, 1)) ?>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg">
          <div class="px-3 py-2 border-bottom border-secondary border-opacity-25">
            <div class="fw-bold text-white"><?= html_escape($_user['full_name'] ?? 'User') ?></div>
            <div class="small text-muted"><?= ucfirst($_user['role_name'] ?? 'Role') ?></div>
          </div>
          <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger mt-1"><i class="ti ti-logout me-2"></i>Keluar</a>
        </div>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">
        
        <!-- Dashboard -->
        <li class="nav-item <?= ($uri_segment == 'dashboard' || ($uri_segment == '' && $role != 'tentor')) ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-dashboard"></i></span>
            <span class="nav-link-title">
              <?php if (in_array($role, array('guru', 'walikelas'))): ?>
                Dashboard Jurnal Guru
              <?php else: ?>
                Dashboard Utama
              <?php endif; ?>
            </span>
          </a>
        </li>

        <!-- Jurnal Guru Dropdown -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'jurnal') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-jurnal" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-book"></i></span>
            <span class="nav-link-title">Jurnal Guru</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'jurnal') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'jurnal' && $sub_segment == '') ? 'active' : '' ?>" href="<?= base_url('jurnal') ?>">Daftar Jurnal</a>
            <a class="dropdown-item <?= ($uri_segment == 'jurnal' && $sub_segment == 'add') ? 'active' : '' ?>" href="<?= base_url('jurnal/add') ?>">Input Jurnal Baru</a>
            <a class="dropdown-item <?= ($uri_segment == 'jurnal' && $sub_segment == 'jadwal') ? 'active' : '' ?>" href="<?= base_url('jurnal/jadwal') ?>">Jadwal Mengajar</a>
          </div>
        </li>
        <?php endif; ?>

        <!-- Presensi Kelas -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'presensikelas') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('presensikelas') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-building-community"></i></span>
            <span class="nav-link-title">Presensi Kelas</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Presensi Siswa -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'presensi') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('presensi') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-user-check"></i></span>
            <span class="nav-link-title">Presensi Siswa</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Poin Keaktifan Siswa -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'poinkeaktifan') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('poinkeaktifan') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-star text-warning"></i></span>
            <span class="nav-link-title">Poin Keaktifan</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Penilaian Dropdown -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'penilaian') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-penilaian" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-chart-bar"></i></span>
            <span class="nav-link-title">Penilaian</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'penilaian') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'penilaian' && $sub_segment == '') ? 'active' : '' ?>" href="<?= base_url('penilaian') ?>">Input Nilai</a>
            <a class="dropdown-item <?= ($uri_segment == 'penilaian' && $sub_segment == 'rekap') ? 'active' : '' ?>" href="<?= base_url('penilaian/rekap') ?>">Rekap Nilai</a>
            <a class="dropdown-item <?= ($uri_segment == 'penilaian' && $sub_segment == 'import_history') ? 'active' : '' ?>" href="<?= base_url('penilaian/import_history') ?>">Riwayat Import</a>
          </div>
        </li>
        <?php endif; ?>
 
        <!-- Perkembangan Diri -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'perkembangan') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('perkembangan') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-user-exclamation"></i></span>
            <span class="nav-link-title">Perkembangan Diri</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Karya/Luaran Pembelajaran -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'waka', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'karya') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('karya') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-share"></i></span>
            <span class="nav-link-title">Karya Pembelajaran</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Perangkat Ajar Dropdown -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'waka', 'kamad'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'perangkat_ajar') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-perangkat" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-notebook text-indigo"></i></span>
            <span class="nav-link-title">Perangkat Ajar</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'perangkat_ajar') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == '') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar') ?>">Dashboard Perangkat</a>
            <?php if (in_array($role, array('admin', 'superadmin', 'guru'))): ?>
              <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == 'upload') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar/upload') ?>">Informasi Utama (Upload)</a>
              <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == 'rencana') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar/rencana') ?>">Rencana Pelaksanaan</a>
            <?php endif; ?>
            <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == 'daftar') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar/daftar') ?>">Daftar Perangkat</a>
            <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == 'revisi') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar/revisi') ?>">Riwayat Revisi</a>
            <?php if (in_array($role, array('admin', 'superadmin', 'waka', 'kamad'))): ?>
              <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == 'verifikasi') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar/verifikasi') ?>">Verifikasi Perangkat</a>
            <?php endif; ?>
            <a class="dropdown-item <?= ($uri_segment == 'perangkat_ajar' && $sub_segment == 'arsip') ? 'active' : '' ?>" href="<?= base_url('perangkat_ajar/arsip') ?>">Arsip Perangkat</a>
          </div>
        </li>
        <?php endif; ?>

        <!-- Wali Kelas Dropdown -->
        <?php if (in_array($role, array('admin', 'superadmin', 'walikelas'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'walikelas') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-walikelas" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-users"></i></span>
            <span class="nav-link-title">Wali Kelas</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'walikelas') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'walikelas' && $sub_segment == '') ? 'active' : '' ?>" href="<?= base_url('walikelas') ?>">Dashboard Wali</a>
            <a class="dropdown-item <?= ($uri_segment == 'walikelas' && $sub_segment == 'program_kelas') ? 'active' : '' ?>" href="<?= base_url('walikelas/program_kelas') ?>">Program Kelas</a>
            <a class="dropdown-item <?= ($uri_segment == 'walikelas' && $sub_segment == 'penanganan_siswa') ? 'active' : '' ?>" href="<?= base_url('walikelas/penanganan_siswa') ?>">Penanganan Siswa</a>
            <a class="dropdown-item <?= ($uri_segment == 'walikelas' && $sub_segment == 'rekap_pelanggaran') ? 'active' : '' ?>" href="<?= base_url('walikelas/rekap_pelanggaran') ?>">Rekap Pelanggaran</a>
            <a class="dropdown-item <?= ($uri_segment == 'walikelas' && $sub_segment == 'kokurikuler') ? 'active' : '' ?>" href="<?= base_url('walikelas/kokurikuler') ?>">Aktivitas Kokurikuler</a>
          </div>
        </li>
        <?php endif; ?>
 
        <!-- Master Data (Admin Only) -->
        <?php if (in_array($role, array('admin', 'superadmin'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'master') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-master" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-database"></i></span>
            <span class="nav-link-title">Master Data</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'master') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($sub_segment == 'tahun_pelajaran') ? 'active' : '' ?>" href="<?= base_url('master/tahun_pelajaran') ?>">Tahun Pelajaran</a>
            <a class="dropdown-item <?= ($sub_segment == 'kelas') ? 'active' : '' ?>" href="<?= base_url('master/kelas') ?>">Data Kelas</a>
            <a class="dropdown-item <?= ($sub_segment == 'ruangan') ? 'active' : '' ?>" href="<?= base_url('master/ruangan') ?>">Data Ruangan</a>
            <a class="dropdown-item <?= ($sub_segment == 'mapel') ? 'active' : '' ?>" href="<?= base_url('master/mapel') ?>">Mata Pelajaran</a>
            <a class="dropdown-item <?= ($sub_segment == 'jam_pelajaran') ? 'active' : '' ?>" href="<?= base_url('master/jam_pelajaran') ?>">Jam Pelajaran</a>
            <a class="dropdown-item <?= ($sub_segment == 'guru') ? 'active' : '' ?>" href="<?= base_url('master/guru') ?>">Data Guru</a>
            <a class="dropdown-item <?= ($sub_segment == 'siswa') ? 'active' : '' ?>" href="<?= base_url('master/siswa') ?>">Data Siswa</a>
            <a class="dropdown-item <?= ($sub_segment == 'jadwal') ? 'active' : '' ?>" href="<?= base_url('master/jadwal') ?>">Jadwal Pelajaran</a>
          </div>
        </li>
        <?php endif; ?>

        <!-- Modul MBF (Admin Only) -->
        <?php if (in_array($role, array('admin', 'superadmin'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'mbf') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-mbf" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-school text-emerald"></i></span>
            <span class="nav-link-title fw-bold text-emerald">Modul MBF (Admin)</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'mbf') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'mbf' && $sub_segment == '') ? 'active' : '' ?>" href="<?= base_url('mbf') ?>">Dashboard MBF</a>
            <a class="dropdown-item <?= ($sub_segment == 'tentor') ? 'active' : '' ?>" href="<?= base_url('mbf/tentor') ?>">Tentor MBF</a>
            <a class="dropdown-item <?= ($sub_segment == 'mapel') ? 'active' : '' ?>" href="<?= base_url('mbf/mapel') ?>">Mapel MBF</a>
            <a class="dropdown-item <?= ($sub_segment == 'siswa') ? 'active' : '' ?>" href="<?= base_url('mbf/siswa') ?>">Siswa MBF</a>
            <a class="dropdown-item <?= ($sub_segment == 'presensi') ? 'active' : '' ?>" href="<?= base_url('mbf/presensi') ?>">Presensi MBF</a>
            <a class="dropdown-item <?= ($sub_segment == 'rekap') ? 'active' : '' ?>" href="<?= base_url('mbf/rekap') ?>">Rekap Presensi</a>
            <a class="dropdown-item <?= ($sub_segment == 'laporan') ? 'active' : '' ?>" href="<?= base_url('mbf/laporan') ?>">Laporan MBF</a>
          </div>
        </li>
        <?php endif; ?>

        <!-- Tentor Navigation Dropdown (Tentor or Teacher assigned as Tentor) -->
        <?php 
        $is_tentor_user = ($role == 'tentor');
        if (!$is_tentor_user && !empty($_user['id'])) {
            $CI =& get_instance();
            $CI->load->model('mbf_model');
            $check_tentor_reg = $CI->mbf_model->get_tentor_by_user_id($_user['id']);
            if (!empty($check_tentor_reg)) {
                $is_tentor_user = true;
            }
        }
        ?>
        <?php if ($is_tentor_user): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'tentor') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-tentor" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-certificate text-emerald"></i></span>
            <span class="nav-link-title fw-bold text-emerald">Modul Tentor MBF</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'tentor') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && ($sub_segment == '' || $sub_segment == 'dashboard')) ? 'active' : '' ?>" href="<?= base_url('tentor') ?>">
              <i class="ti ti-dashboard me-2 text-primary"></i> Dashboard Tentor MBF
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && $sub_segment == 'mapel') ? 'active' : '' ?>" href="<?= base_url('tentor/mapel') ?>">
              <i class="ti ti-books me-2 text-info"></i> Mapel MBF Saya
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && $sub_segment == 'peserta') ? 'active' : '' ?>" href="<?= base_url('tentor/peserta') ?>">
              <i class="ti ti-users me-2 text-success"></i> Peserta MBF Saya
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && $sub_segment == 'presensi') ? 'active' : '' ?>" href="<?= base_url('tentor/presensi') ?>">
              <i class="ti ti-user-check me-2 text-warning"></i> Presensi Siswa MBF
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && $sub_segment == 'rekap') ? 'active' : '' ?>" href="<?= base_url('tentor/rekap') ?>">
              <i class="ti ti-chart-bar me-2 text-indigo"></i> Rekap Presensi MBF
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && $sub_segment == 'laporan') ? 'active' : '' ?>" href="<?= base_url('tentor/laporan') ?>">
              <i class="ti ti-file-report me-2 text-danger"></i> Laporan MBF Saya
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'tentor' && $sub_segment == 'profil') ? 'active' : '' ?>" href="<?= base_url('tentor/profil') ?>">
              <i class="ti ti-user-cog me-2 text-secondary"></i> Profil Saya
            </a>
          </div>
        </li>
        <?php endif; ?>

        <!-- Supervisi Akademik Dropdown (Admin, Superadmin, Kamad, Waka, Guru) -->
        <?php if (in_array($role, array('admin', 'superadmin', 'kamad', 'waka', 'guru'))): ?>
        <li class="nav-item dropdown <?= ($uri_segment == 'supervisi') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#navbar-supervisi" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon me-2"><i class="ti ti-clipboard-check text-warning"></i></span>
            <span class="nav-link-title fw-bold text-warning">Supervisi Akademik</span>
          </a>
          <div class="dropdown-menu <?= ($uri_segment == 'supervisi') ? 'show' : '' ?>">
            <a class="dropdown-item <?= ($uri_segment == 'supervisi' && ($sub_segment == '' || $sub_segment == 'dashboard')) ? 'active' : '' ?>" href="<?= base_url('supervisi/dashboard') ?>">
              <i class="ti ti-dashboard me-2 text-primary"></i> 1. Dashboard Supervisi
            </a>
            <?php if (in_array($role, array('admin', 'superadmin', 'kamad', 'waka'))): ?>
              <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'guru') ? 'active' : '' ?>" href="<?= base_url('supervisi/guru') ?>">
                <i class="ti ti-users me-2 text-info"></i> 2. Daftar Guru
              </a>
              <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'form1') ? 'active' : '' ?>" href="<?= base_url('supervisi/form1') ?>">
                <i class="ti ti-file-text me-2 text-indigo"></i> 3. Form 1: Administrasi Guru
              </a>
              <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'form2') ? 'active' : '' ?>" href="<?= base_url('supervisi/form2') ?>">
                <i class="ti ti-file-description me-2 text-teal"></i> 4. Form 2: RPP / Modul Ajar
              </a>
              <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'form3') ? 'active' : '' ?>" href="<?= base_url('supervisi/form3') ?>">
                <i class="ti ti-video me-2 text-purple"></i> 5. Form 3: Observasi Kelas
              </a>
              <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'form4') ? 'active' : '' ?>" href="<?= base_url('supervisi/form4') ?>">
                <i class="ti ti-chart-bar me-2 text-pink"></i> 6. Form 4: Penilaian Siswa
              </a>
            <?php endif; ?>
            <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'rekap') ? 'active' : '' ?>" href="<?= base_url('supervisi/rekap') ?>">
              <i class="ti ti-report-analytics me-2 text-success"></i> 7. Rekap Supervisi
            </a>
            <a class="dropdown-item <?= ($uri_segment == 'supervisi' && $sub_segment == 'laporan') ? 'active' : '' ?>" href="<?= base_url('supervisi/laporan') ?>">
              <i class="ti ti-printer me-2 text-danger"></i> 8. Laporan Supervisi
            </a>
          </div>
        </li>
        <?php endif; ?>

        <!-- Monitoring KBM (Kepala Madrasah & Admin) -->
        <?php if (in_array($role, array('admin', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'monitoring') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('monitoring') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-report-analytics"></i></span>
            <span class="nav-link-title">Monitoring KBM</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Laporan Jurnal Guru (Guru, Wali Kelas, Admin, Waka, Kamad) -->
        <?php if (in_array($role, array('admin', 'superadmin', 'guru', 'walikelas', 'waka', 'kamad'))): ?>
        <li class="nav-item <?= ($uri_segment == 'laporan') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('laporan') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-file-report text-primary"></i></span>
            <span class="nav-link-title">Laporan Jurnal Guru</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Audit Log (Admin Only) -->
        <?php if (in_array($role, array('admin', 'superadmin'))): ?>
        <li class="nav-item <?= ($uri_segment == 'logs') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('logs') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-history"></i></span>
            <span class="nav-link-title">Activity Log</span>
          </a>
        </li>
        <li class="nav-item <?= ($uri_segment == 'system_monitor') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('system_monitor') ?>">
            <span class="nav-link-icon me-2 text-indigo"><i class="ti ti-cpu"></i></span>
            <span class="nav-link-title text-indigo">System Monitor</span>
          </a>
        </li>
        <li class="nav-item <?= ($uri_segment == 'google_drive_sync') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('google_drive_sync') ?>">
            <span class="nav-link-icon me-2 text-success"><i class="ti ti-brand-google-drive"></i></span>
            <span class="nav-link-title text-success font-weight-bold">Google Drive Sync</span>
          </a>
        </li>
        <li class="nav-item <?= ($uri_segment == 'settings') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('settings') ?>">
            <span class="nav-link-icon me-2"><i class="ti ti-settings"></i></span>
            <span class="nav-link-title">Pengaturan</span>
          </a>
        </li>

        <?php endif; ?>

      </ul>
    </div>
  </div>
</aside>
