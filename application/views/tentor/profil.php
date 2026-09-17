<div class="page-header d-print-none mb-3">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle text-secondary">MODUL TENTOR MBF</div>
        <h2 class="page-title text-dark">
          <i class="ti ti-user-cog me-2 text-primary"></i> PROFIL & AKUN SAYA
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-2 fs-2"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom py-3">
            <h3 class="card-title text-dark mb-0"><i class="ti ti-user me-2 text-primary"></i> EDIT INFORMASI PROFIL & PASSWORD</h3>
          </div>
          <div class="card-body">
            <form action="<?= base_url('tentor/profil') ?>" method="POST">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
              
              <div class="mb-3">
                <label class="form-label required">Nama Lengkap Tentor</label>
                <input type="text" name="nama_lengkap" class="form-control" required value="<?= html_escape($tentor['nama_lengkap'] ?? '') ?>">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">NIP / ID Tentor</label>
                  <input type="text" class="form-control bg-light text-muted" readonly value="<?= html_escape($tentor['nip'] ?? '-') ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">No. HP / WhatsApp</label>
                  <input type="text" name="no_hp" class="form-control" value="<?= html_escape($tentor['no_hp'] ?? '') ?>">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= html_escape($tentor['email'] ?? '') ?>">
              </div>

              <hr>

              <div class="mb-3">
                <label class="form-label">Username Login</label>
                <input type="text" class="form-control bg-light text-muted" readonly value="<?= html_escape($tentor['username'] ?? '') ?>">
              </div>

              <div class="mb-3">
                <label class="form-label">Password Baru <span class="text-muted small">(Kosongkan jika tidak ingin merubah)</span></label>
                <input type="password" name="new_password" class="form-control" placeholder="******">
              </div>

              <div class="text-end pt-2">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                  <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan Profil
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
