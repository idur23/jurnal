<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Karya & Luaran Pembelajaran</h2>
      <div class="text-muted small mt-1">Daftar publikasi dan dokumentasi karya inovatif pembelajaran yang dihasilkan oleh guru.</div>
    </div>
    <div class="col-auto ms-auto">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddKarya">
        <i class="ti ti-plus me-1"></i> Unggah Karya Baru
      </button>
    </div>
  </div>
</div>

<div class="row row-cards">
  <?php if (empty($list_karya)): ?>
    <div class="col-12 text-center text-muted py-5 card">
      <i class="ti ti-share fs-1 text-primary mb-2"></i>
      <h3>Belum ada karya pembelajaran yang diunggah.</h3>
      <p class="mb-0">Klik tombol <strong>Unggah Karya Baru</strong> di kanan atas untuk mempublikasikan karya pertama Anda.</p>
    </div>
  <?php else: ?>
    <?php foreach ($list_karya as $k): ?>
      <div class="col-md-4">
        <div class="card card-stacked h-100">
          <div class="card-body d-flex flex-column">
            <!-- Icon/Preview Header based on type -->
            <div class="d-flex align-items-center mb-3">
              <span class="avatar avatar-md bg-indigo-lt rounded-3 me-3 text-indigo">
                <?php if ($k['jenis_karya'] == 'Foto' || $k['jenis_karya'] == 'Poster'): ?>
                  <i class="ti ti-photo fs-2"></i>
                <?php elseif ($k['jenis_karya'] == 'Video'): ?>
                  <i class="ti ti-video fs-2"></i>
                <?php elseif ($k['jenis_karya'] == 'PDF'): ?>
                  <i class="ti ti-file-text fs-2"></i>
                <?php elseif ($k['jenis_karya'] == 'PowerPoint'): ?>
                  <i class="ti ti-presentation fs-2"></i>
                <?php else: ?>
                  <i class="ti ti-briefcase fs-2"></i>
                <?php endif; ?>
              </span>
              <div class="overflow-hidden">
                <h4 class="m-0 text-truncate"><a href="<?= base_url($k['file_path']) ?>" target="_blank" class="text-reset"><?= html_escape($k['judul']) ?></a></h4>
                <div class="text-muted small"><?= html_escape($k['jenis_karya']) ?> | <?= date('d M Y', strtotime($k['tanggal'])) ?></div>
              </div>
            </div>

            <!-- Description -->
            <p class="text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
              <?= html_escape($k['deskripsi'] ? $k['deskripsi'] : 'Tidak ada deskripsi.') ?>
            </p>

            <!-- Metadata details -->
            <div class="mt-auto border-top pt-2">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-purple-lt fw-bold">Kelas: <?= html_escape($k['nama_kelas']) ?></span>
                <span class="badge bg-indigo-lt fw-bold"><?= html_escape($k['nama_mapel']) ?></span>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small text-muted"><i class="ti ti-user me-1"></i><?= html_escape($k['nama_guru']) ?></span>
                <span class="badge <?= $k['status_publikasi'] == 'Publik' ? 'bg-success-lt' : 'bg-warning-lt' ?>"><?= html_escape($k['status_publikasi']) ?></span>
              </div>

              <!-- Tags if any -->
              <?php if ($k['tags']): ?>
                <div class="mb-3">
                  <?php foreach (explode(',', $k['tags']) as $t): ?>
                    <span class="badge bg-secondary-lt me-1">#<?= html_escape(trim($t)) ?></span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <!-- Action buttons -->
              <div class="btn-list d-flex flex-nowrap">
                <a href="<?= base_url($k['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary flex-fill">
                  <i class="ti ti-eye me-1"></i> Preview / Unduh
                </a>
                
                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEditKarya_<?= $k['id'] ?>" title="Edit Karya">
                  <i class="ti ti-edit"></i>
                </button>

                <form action="<?= base_url('karya') ?>" method="POST" class="d-inline flex-shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya ini?')">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $k['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Karya">
                    <i class="ti ti-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Edit Karya -->
      <div class="modal modal-blur fade" id="modalEditKarya_<?= $k['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form action="<?= base_url('karya') ?>" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="id" value="<?= $k['id'] ?>">

              <div class="modal-header">
                <h5 class="modal-title">Edit Karya: <?= html_escape($k['judul']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label required">Judul Karya</label>
                  <input type="text" name="judul" class="form-control" value="<?= html_escape($k['judul']) ?>" required>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label required">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                      <?php foreach ($list_kelas as $kls): ?>
                        <option value="<?= $kls['id'] ?>" <?= $k['kelas_id'] == $kls['id'] ? 'selected' : '' ?>><?= html_escape($kls['nama_kelas']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label required">Mata Pelajaran</label>
                    <select name="mapel_id" class="form-select" required>
                      <?php foreach ($list_mapel as $mpl): ?>
                        <option value="<?= $mpl['id'] ?>" <?= $k['mapel_id'] == $mpl['id'] ? 'selected' : '' ?>><?= html_escape($mpl['nama_mapel']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label required">Tanggal Pembuatan</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= html_escape($k['tanggal']) ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label required">Jenis Karya / Luaran</label>
                    <select name="jenis_karya" class="form-select" required>
                      <?php foreach (array('Foto', 'Video', 'PDF', 'PowerPoint', 'Word', 'LKPD', 'Poster', 'Produk', 'Portofolio') as $jk): ?>
                        <option value="<?= $jk ?>" <?= $k['jenis_karya'] == $jk ? 'selected' : '' ?>><?= $jk ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label required">Materi Pokok / Pembahasan</label>
                  <input type="text" name="materi" class="form-control" value="<?= html_escape($k['materi']) ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Deskripsi Singkat Karya</label>
                  <textarea name="deskripsi" class="form-control" rows="3"><?= html_escape($k['deskripsi']) ?></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tags (Pisahkan dengan koma)</label>
                  <input type="text" name="tags" class="form-control" value="<?= html_escape($k['tags']) ?>" placeholder="Contoh: p5, coding, website">
                </div>
                <div class="mb-3">
                  <label class="form-label">Status Publikasi</label>
                  <select name="status_publikasi" class="form-select">
                    <option value="Draft" <?= $k['status_publikasi'] == 'Draft' ? 'selected' : '' ?>>Draft (Hanya Saya)</option>
                    <option value="Publik" <?= $k['status_publikasi'] == 'Publik' ? 'selected' : '' ?>>Publik (Semua Guru)</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Ganti File Karya (Biarkan kosong jika tidak diubah)</label>
                  <input type="file" name="file_karya" class="form-control">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning fw-bold">Update Karya</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<!-- Modal Add Karya -->
<div class="modal modal-blur fade" id="modalAddKarya" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="<?= base_url('karya') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="add">

        <div class="modal-header">
          <h5 class="modal-title">Unggah Karya Pembelajaran Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Judul Karya</label>
            <input type="text" name="judul" class="form-control" placeholder="Tulis judul karya..." required>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Kelas</label>
              <select name="kelas_id" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($list_kelas as $kls): ?>
                  <option value="<?= $kls['id'] ?>"><?= html_escape($kls['nama_kelas']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Mata Pelajaran</label>
              <select name="mapel_id" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                <?php foreach ($list_mapel as $mpl): ?>
                  <option value="<?= $mpl['id'] ?>"><?= html_escape($mpl['nama_mapel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Tanggal Pembuatan</label>
              <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Jenis Karya / Luaran</label>
              <select name="jenis_karya" class="form-select" required>
                <option value="Foto">Foto Dokumentasi</option>
                <option value="Video">Video Pembelajaran</option>
                <option value="PDF">E-Book / PDF</option>
                <option value="PowerPoint">PowerPoint Presentasi</option>
                <option value="Word">Word Dokumen</option>
                <option value="LKPD">Lembar Kerja Siswa (LKPD)</option>
                <option value="Poster">Poster Infografis</option>
                <option value="Produk">Produk Fisik/Digital</option>
                <option value="Portofolio">Portofolio Pembelajaran</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Materi Pokok / Pembahasan</label>
            <input type="text" name="materi" class="form-control" placeholder="Contoh: Pembuatan Website E-Commerce" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi Singkat Karya</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tulis ringkasan mengenai karya inovatif ini..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Tags (Pisahkan dengan koma)</label>
            <input type="text" name="tags" class="form-control" placeholder="Contoh: p5, coding, website">
          </div>
          <div class="mb-3">
            <label class="form-label">Status Publikasi</label>
            <select name="status_publikasi" class="form-select">
              <option value="Draft">Draft (Hanya Saya)</option>
              <option value="Publik">Publik (Semua Guru)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Pilih File Karya</label>
            <input type="file" name="file_karya" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary fw-bold">Unggah Karya</button>
        </div>
      </form>
    </div>
  </div>
</div>
