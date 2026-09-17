<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('layout/sidebar'); ?>

<div class="page-wrapper">
  <!-- Top Header Bar -->
  <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none border-bottom">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="navbar-nav flex-row order-md-last ms-auto align-items-center">
        <!-- User Dropdown Menu -->
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm bg-primary text-white fw-bold me-2">
              <?= strtoupper(substr($_user['full_name'] ?? 'U', 0, 1)) ?>
            </span>
            <div class="d-none d-xl-block ps-2">
              <div><?= html_escape($_user['full_name'] ?? 'User') ?></div>
              <div class="mt-1 small text-muted"><?= ucfirst($_user['role_name'] ?? 'Role') ?></div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger"><i class="ti ti-logout me-2"></i>Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Body Content -->
  <div class="page-body">
    <div class="container-fluid">
      
      <!-- Flash Notification -->
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <div class="d-flex">
            <div><i class="ti ti-check alert-icon fs-2 me-2"></i></div>
            <div><?= $this->session->flashdata('success') ?></div>
          </div>
          <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <div class="d-flex">
            <div><i class="ti ti-alert-triangle alert-icon fs-2 me-2"></i></div>
            <div><?= $this->session->flashdata('error') ?></div>
          </div>
          <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
      <?php endif; ?>

      <?= $_content ?>
    </div>
  </div>

<script>
  (function() {
    // Force light theme and clean up dark theme settings
    document.body.classList.remove('theme-dark');
    document.body.classList.add('theme-light');
    localStorage.setItem('jg_theme', 'light');
  })();
</script>

<?php $this->load->view('layout/footer'); ?>
