<div class="container-xl">
  <!-- Page Header -->
  <div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
      <div class="col">
        <div class="page-pretitle">Profil & Riwayat Supervisi</div>
        <h2 class="page-title text-primary fw-bold">
          <i class="ti ti-user-check me-2"></i><?= html_escape($guru['nama_lengkap']) ?>
        </h2>
        <div class="text-muted small mt-1">NIP: <?= html_escape(!empty($guru['nip']) ? $guru['nip'] : '-') ?> | NIK: <?= html_escape(!empty($guru['nik']) ? $guru['nik'] : '-') ?></div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <a href="<?= base_url('supervisi/guru') ?>" class="btn btn-outline-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Guru
        </a>
      </div>
    </div>
  </div>

  <!-- Growth Trend Chart -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent">
      <h3 class="card-title fw-bold text-dark mb-0">
        <i class="ti ti-trending-up me-2 text-success"></i>Grafik Perkembangan Hasil Supervisi Guru
      </h3>
    </div>
    <div class="card-body">
      <?php if (empty($history)): ?>
        <div class="text-center py-4 text-muted">Belum ada riwayat supervisi untuk ditampilkan pada grafik.</div>
      <?php else: ?>
        <div id="chart-guru-trend" style="min-height: 280px;"></div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Supervision History Table -->
  <div class="card border-0 shadow-sm mb-5">
    <div class="card-header bg-transparent">
      <h3 class="card-title fw-bold text-dark mb-0"><i class="ti ti-history me-2 text-indigo"></i>Riwayat Supervisi Form 1 - Form 4</h3>
    </div>
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-hover">
        <thead>
          <tr class="bg-light">
            <th class="w-1">No</th>
            <th>Form Instrumen</th>
            <th>Tahap</th>
            <th>Tanggal</th>
            <th>Mata Pelajaran / Kelas</th>
            <th>Supervisor</th>
            <th>Nilai Akhir</th>
            <th>Status</th>
            <th>Tindak Lanjut & Respon</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($history)): ?>
            <tr>
              <td colspan="10" class="text-center py-4 text-muted">Belum ada riwayat supervisi.</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; foreach ($history as $h): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= html_escape($h['nama_form']) ?></div>
                  <span class="badge bg-indigo-lt"><?= html_escape($h['kode_form']) ?></span>
                </td>
                <td><span class="badge bg-blue-lt"><?= html_escape($h['tahap']) ?></span></td>
                <td><?= date('d/m/Y', strtotime($h['tanggal_supervisi'])) ?></td>
                <td>
                  <div><?= html_escape($h['nama_mapel'] ?? '-') ?></div>
                  <div class="small text-muted">Kelas: <?= html_escape($h['nama_kelas'] ?? '-') ?></div>
                </td>
                <td><?= html_escape($h['nama_supervisor'] ?? 'Supervisor') ?></td>
                <td>
                  <span class="fw-bold fs-3 <?= $h['nilai_akhir'] >= 80 ? 'text-success' : ($h['nilai_akhir'] >= 70 ? 'text-primary' : 'text-warning') ?>">
                    <?= number_format($h['nilai_akhir'], 1) ?>
                  </span>
                </td>
                <td>
                  <?php if ($h['status'] == 'SELESAI'): ?>
                    <span class="badge bg-success">Selesai</span>
                  <?php elseif ($h['status'] == 'DALAM PROSES'): ?>
                    <span class="badge bg-warning">Dalam Proses</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Draft</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="small">
                    <span class="fw-bold">Status TL:</span> 
                    <span class="badge bg-gray-lt"><?= html_escape($h['status_tindak_lanjut']) ?></span>
                  </div>
                  <?php if (!empty($h['respon_guru'])): ?>
                    <div class="small text-muted mt-1"><em>"<?= html_escape($h['respon_guru']) ?>"</em></div>
                  <?php endif; ?>
                  
                  <!-- Teacher Action: Respon Tindak Lanjut Modal -->
                  <?php if ($user_role == 'guru' || $user_role == 'admin' || $user_role == 'superadmin'): ?>
                    <button class="btn btn-sm btn-link p-0 text-decoration-none mt-1" data-bs-toggle="modal" data-bs-target="#modalTL_<?= $h['id'] ?>">
                      <i class="ti ti-edit me-1"></i> Update Respon TL
                    </button>

                    <!-- Modal Update Tindak Lanjut -->
                    <div class="modal fade" id="modalTL_<?= $h['id'] ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <form method="POST" action="<?= base_url('supervisi/update_tindak_lanjut') ?>">
                            <input type="hidden" name="supervisi_id" value="<?= $h['id'] ?>">
                            <input type="hidden" name="guru_id" value="<?= $guru['id'] ?>">
                            <div class="modal-header">
                              <h5 class="modal-title fw-bold">Update Respon Tindak Lanjut</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                              <div class="mb-3">
                                <label class="form-label">Tindak Lanjut Supervisor:</label>
                                <div class="p-2 bg-light rounded text-muted small"><?= nl2br(html_escape($h['tindak_lanjut'] ? $h['tindak_lanjut'] : 'Tidak ada catatan tindak lanjut.')) ?></div>
                              </div>
                              <div class="mb-3">
                                <label class="form-label required">Status Tindak Lanjut</label>
                                <select name="status_tindak_lanjut" class="form-select" required>
                                  <option value="Belum Ditindaklanjuti" <?= ($h['status_tindak_lanjut'] == 'Belum Ditindaklanjuti') ? 'selected' : '' ?>>Belum Ditindaklanjuti</option>
                                  <option value="Dalam Proses" <?= ($h['status_tindak_lanjut'] == 'Dalam Proses') ? 'selected' : '' ?>>Dalam Proses</option>
                                  <option value="Selesai" <?= ($h['status_tindak_lanjut'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label required">Respon / Catatan Guru</label>
                                <textarea name="respon_guru" class="form-control" rows="3" required placeholder="Tuliskan respon atau progres pelaksanaan tindak lanjut..."><?= html_escape($h['respon_guru'] ?? '') ?></textarea>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Simpan Respon</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <div class="btn-list flex-nowrap justify-content-end">
                    <a href="<?= base_url('supervisi/form' . $h['form_id'] . '?id=' . $h['id']) ?>" class="btn btn-sm btn-outline-primary" title="Buka Instrument">
                      <i class="ti ti-eye"></i>
                    </a>
                    <a href="<?= base_url('supervisi/export_pdf/' . $h['id']) ?>" target="_blank" class="btn btn-sm btn-outline-danger" title="Download PDF">
                      <i class="ti ti-file-pdf"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php if (!empty($history)): ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  var historyDates = [<?php foreach (array_reverse($history) as $h) { echo "'" . date('d/m/Y', strtotime($h['tanggal_supervisi'])) . " (" . $h['kode_form'] . ")',"; } ?>];
  var historyScores = [<?php foreach (array_reverse($history) as $h) { echo round($h['nilai_akhir'], 1) . ","; } ?>];

  var optionsTrend = {
    series: [{ name: 'Nilai Supervisi', data: historyScores }],
    chart: { type: 'line', height: 280, stroke: { curve: 'smooth' } },
    colors: ['#2fb344'],
    markers: { size: 5 },
    xaxis: { categories: historyDates },
    yaxis: { max: 100 }
  };
  new ApexCharts(document.querySelector("#chart-guru-trend"), optionsTrend).render();
});
</script>
<?php endif; ?>
