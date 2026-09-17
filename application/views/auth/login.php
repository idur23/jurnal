<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Login - Website Jurnal Guru Enterprise</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <?php if (file_exists('./assets/css/tabler-icons.min.css')): ?>
      <link rel="stylesheet" href="<?= base_url('assets/css/tabler-icons.min.css') ?>">
    <?php else: ?>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <?php endif; ?>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        min-height: 100vh;
      }
      .card-login {
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
      }
    </style>
  </head>
  <body class="d-flex flex-column justify-content-center py-4">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark text-white fs-1 fw-bold">
          <i class="ti ti-notebook text-primary me-2"></i>Jurnal Guru<span class="text-primary">.Enterprise</span>
        </a>
      </div>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <div class="d-flex">
            <div><i class="ti ti-alert-triangle alert-icon fs-2 me-2"></i></div>
            <div><?= $this->session->flashdata('error') ?></div>
          </div>
          <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
      <?php endif; ?>

      <form class="card card-md card-login bg-dark text-white border-secondary" action="<?= base_url('login') ?>" method="POST" autocomplete="off">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        
        <div class="card-body">
          <h2 class="card-title text-center mb-4 text-white fs-2">Masuk ke Akun Anda</h2>
          
          <div class="mb-3">
            <label class="form-label text-light">Username atau Email</label>
            <div class="input-icon">
              <span class="input-icon-addon"><i class="ti ti-user text-muted"></i></span>
              <input type="text" name="identity" class="form-control form-control-dark bg-secondary text-white border-0" placeholder="admin / guru1 / wali1" value="<?= set_value('identity') ?>" required autofocus>
            </div>
            <?= form_error('identity', '<div class="text-danger small mt-1">', '</div>') ?>
          </div>
          
          <div class="mb-3">
            <label class="form-label text-light">Password</label>
            <div class="input-icon">
              <span class="input-icon-addon"><i class="ti ti-lock text-muted"></i></span>
              <input type="password" name="password" class="form-control form-control-dark bg-secondary text-white border-0" placeholder="Masukkan password" required>
            </div>
            <?= form_error('password', '<div class="text-danger small mt-1">', '</div>') ?>
          </div>

          <div class="form-footer mt-4">
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="ti ti-login me-2"></i>Masuk Sekarang</button>
          </div>
        </div>

      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
  </body>
</html>
