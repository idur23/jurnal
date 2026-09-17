<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <div class="page-pretitle">Modul Perkembangan Diri</div>
      <h2 class="page-title">Profil Perkembangan Diri Siswa</h2>
      <div class="text-muted small mt-1">Rekapitulasi terintegrasi catatan guru mapel, presensi, penilaian akademik, dan evaluasi wali kelas.</div>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <a href="<?= base_url('laporan/perkembangan_pdf?siswa_id=' . $siswa['id']) ?>" target="_blank" class="btn btn-outline-danger">
          <i class="ti ti-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= base_url('laporan/perkembangan_excel?siswa_id=' . $siswa['id']) ?>" class="btn btn-outline-success">
          <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
        </a>
        <a href="<?= base_url('perkembangan') ?>?kelas_id=<?= $siswa['kelas_id'] ?>" class="btn btn-secondary">
          <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row row-cards">
  <!-- Left Side: Student Info, Academic Summary, Attendance Summary -->
  <div class="col-lg-4">
    <!-- Student Profile Card -->
    <div class="card mb-3">
      <div class="card-body text-center py-4">
        <span class="avatar avatar-xl rounded-circle mb-3 bg-indigo text-white shadow-sm" style="font-size: 2.2rem; font-weight: 700;">
          <?= strtoupper(substr($siswa['nama_lengkap'], 0, 1)) ?>
        </span>
        <h3 class="card-title mb-1 text-indigo fw-bold"><?= html_escape($siswa['nama_lengkap']) ?></h3>
        <p class="text-muted mb-3">NIS: <?= html_escape($siswa['nis']) ?> | NISN: <?= html_escape($siswa['nisn']) ?></p>
        <span class="badge bg-indigo-lt px-3 py-2 rounded-pill fw-bold fs-5">Kelas: <?= html_escape($siswa['nama_kelas']) ?></span>
      </div>
      <div class="card-footer p-0">
        <div class="list-group list-group-flush">
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-user me-2"></i>Wali Kelas</span>
            <span class="fw-bold"><?= html_escape($siswa['nama_wali'] ?? '-') ?></span>
          </div>
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-calendar me-2"></i>Tahun Pelajaran</span>
            <span class="fw-bold"><?= html_escape($active_tp['tahun'] . ' (' . $active_tp['semester'] . ')') ?></span>
          </div>
          <div class="list-group-item d-flex justify-content-between py-3">
            <span class="text-muted"><i class="ti ti-percentage me-2"></i>Rata-rata Akademik</span>
            <span class="badge bg-purple text-white fw-bold fs-5"><?= $rata_nilai_total ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Attendance Card -->
    <div class="card mb-3">
      <div class="card-header bg-success text-white">
        <h3 class="card-title text-white"><i class="ti ti-user-check me-2"></i>Kehadiran (Single Source of Truth)</h3>
      </div>
      <div class="card-body">
        <div class="row g-2 text-center">
          <div class="col-4">
            <div class="border p-2 rounded bg-light">
              <div class="text-muted small">Hadir</div>
              <div class="h3 fw-bold text-success mb-0"><?= $presensi['Hadir'] ?></div>
            </div>
          </div>
          <div class="col-4">
            <div class="border p-2 rounded bg-light">
              <div class="text-muted small">Izin</div>
              <div class="h3 fw-bold text-warning mb-0"><?= $presensi['Izin'] ?></div>
            </div>
          </div>
          <div class="col-4">
            <div class="border p-2 rounded bg-light">
              <div class="text-muted small">Sakit</div>
              <div class="h3 fw-bold text-info mb-0"><?= $presensi['Sakit'] ?></div>
            </div>
          </div>
          <div class="col-6 mt-2">
            <div class="border p-2 rounded bg-light">
              <div class="text-muted small">Alpa (Absen)</div>
              <div class="h3 fw-bold text-danger mb-0"><?= $presensi['Alpa'] ?></div>
            </div>
          </div>
          <div class="col-6 mt-2">
            <div class="border p-2 rounded bg-light">
              <div class="text-muted small">Dispen</div>
              <div class="h3 fw-bold text-indigo mb-0"><?= $presensi['Dispen'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Academic Grades Summary Card -->
    <div class="card mb-3">
      <div class="card-header bg-purple text-white">
        <h3 class="card-title text-white"><i class="ti ti-notes me-2"></i>Rata-rata Nilai Per Mapel</h3>
      </div>
      <div class="table-responsive" style="max-height: 250px;">
        <table class="table table-vcenter card-table table-striped table-hover">
          <thead>
            <tr>
              <th>Mata Pelajaran</th>
              <th class="text-end" style="width: 80px;">Rerata</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($nilai_summary)): ?>
              <tr>
                <td colspan="2" class="text-center text-muted">Belum ada data nilai.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($nilai_summary as $ns): ?>
                <tr>
                  <td><?= html_escape($ns['nama_mapel']) ?></td>
                  <td class="text-end fw-bold"><?= number_format($ns['rata_nilai'], 1) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Right Side: Charts, Teacher Catatan, Wali Kelas input form, Previous history -->
  <div class="col-lg-8">
    <!-- Non-academic Radar Graph -->
    <div class="card mb-3">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-chart-radar me-2"></i>Grafik Perkembangan Aspek Non-Akademik</h3>
      </div>
      <div class="card-body d-flex justify-content-center">
        <div style="width: 100%; max-width: 400px; height: 300px;">
          <canvas id="aspectsRadarChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Kelebihan & Kekurangan Rekap -->
    <div class="card mb-3">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white"><i class="ti ti-bulb me-2"></i>Kelebihan & Kekurangan Siswa (Rekap Guru Mapel)</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 border-end">
            <h4 class="fw-bold text-success"><i class="ti ti-circle-plus me-1"></i> Kelebihan / Potensi Diri:</h4>
            <ul class="ps-3 mb-0">
              <?php 
                $has_kel = false;
                foreach ($catatan_mapel as $cm) {
                    if (!empty($cm['kelebihan'])) {
                        $has_kel = true;
                        echo "<li><strong>" . html_escape($cm['nama_mapel']) . "</strong>: " . html_escape($cm['kelebihan']) . "</li>";
                    }
                }
                if (!$has_kel) echo "<li class='text-muted'>Belum ada catatan kelebihan.</li>";
              ?>
            </ul>
          </div>
          <div class="col-md-6">
            <h4 class="fw-bold text-danger"><i class="ti ti-circle-minus me-1"></i> Kekurangan / Area Perbaikan:</h4>
            <ul class="ps-3 mb-0">
              <?php 
                $has_kek = false;
                foreach ($catatan_mapel as $cm) {
                    if (!empty($cm['kekurangan'])) {
                        $has_kek = true;
                        echo "<li><strong>" . html_escape($cm['nama_mapel']) . "</strong>: <span class='text-danger'>" . html_escape($cm['kekurangan']) . "</span></li>";
                    }
                }
                if (!$has_kek) echo "<li class='text-muted'>Belum ada catatan kekurangan.</li>";
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Catatan Detail Seluruh Guru Mapel -->
    <div class="card mb-3">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-message-report me-2"></i>Catatan Perkembangan Dari Guru Mapel</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped table-hover">
          <thead>
            <tr>
              <th>Mapel & Guru</th>
              <th>Catatan Perkembangan</th>
              <th>Saran / Rekomendasi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($catatan_mapel)): ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-4">Belum ada catatan perkembangan terisi.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($catatan_mapel as $cm): ?>
                <tr>
                  <td>
                    <div class="fw-bold"><?= html_escape($cm['nama_mapel']) ?></div>
                    <div class="text-muted small"><?= html_escape($cm['nama_guru']) ?></div>
                  </td>
                  <td class="text-wrap" style="max-width: 250px;"><?= $cm['catatan_perkembangan'] ? html_escape($cm['catatan_perkembangan']) : '-' ?></td>
                  <td class="text-wrap" style="max-width: 250px;"><?= $cm['rekomendasi'] ? html_escape($cm['rekomendasi']) : '-' ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Wali Kelas Final Conclusion Form -->
    <div class="card mb-3 border-indigo">
      <div class="card-header bg-indigo text-white">
        <h3 class="card-title text-white"><i class="ti ti-gavel me-2"></i>Keputusan & Evaluasi Akhir Wali Kelas</h3>
      </div>
      <div class="card-body">
        <?php 
          $can_edit = true;
        ?>
        <?php if ($can_edit): ?>
          <form action="<?= base_url('perkembangan/save_rekap') ?>" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="siswa_id" value="<?= $siswa['id'] ?>">

            <div class="row g-3">
              <div class="col-md-6 mb-3">
                <label class="form-label required">Status Perkembangan Diri Siswa</label>
                <select name="status_perkembangan" class="form-select" required>
                  <option value="Sangat Baik" <?= (($rekap['status_perkembangan'] ?? '') == 'Sangat Baik') ? 'selected' : '' ?>>Sangat Baik</option>
                  <option value="Baik" <?= (($rekap['status_perkembangan'] ?? 'Baik') == 'Baik') ? 'selected' : '' ?>>Baik (Perkembangan Stabil)</option>
                  <option value="Cukup" <?= (($rekap['status_perkembangan'] ?? '') == 'Cukup') ? 'selected' : '' ?>>Cukup</option>
                  <option value="Kurang" <?= (($rekap['status_perkembangan'] ?? '') == 'Kurang') ? 'selected' : '' ?>>Kurang (Perlu Perhatian Khusus)</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label required">Kesimpulan Wali Kelas</label>
              <textarea name="kesimpulan_wali" class="form-control" rows="3" placeholder="Tuliskan kesimpulan akhir perkembangan belajar dan perilaku siswa selama semester ini..." required><?= html_escape($rekap['kesimpulan_wali'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label required">Rekomendasi Tindak Lanjut</label>
              <textarea name="tindak_lanjut" class="form-control" rows="2" placeholder="Tuliskan saran tindak lanjut pendampingan, baik di sekolah maupun di rumah..." required><?= html_escape($rekap['tindak_lanjut'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-indigo fw-bold"><i class="ti ti-device-floppy me-2"></i> Simpan Keputusan Akhir Wali Kelas</button>
          </form>
        <?php else: ?>
          <div class="mb-3">
            <strong class="text-indigo">Status Perkembangan:</strong>
            <span class="badge bg-indigo text-white fw-bold px-3 py-1 rounded-pill ms-2"><?= html_escape($rekap['status_perkembangan'] ?? 'Baik') ?></span>
          </div>
          <div class="mb-3">
            <strong class="text-indigo">Kesimpulan Wali Kelas:</strong>
            <p class="text-muted border p-3 rounded mt-1 bg-light"><?= $rekap && $rekap['kesimpulan_wali'] ? nl2br(html_escape($rekap['kesimpulan_wali'])) : 'Belum diisi wali kelas.' ?></p>
          </div>
          <div class="mb-3">
            <strong class="text-indigo">Rekomendasi Tindak Lanjut:</strong>
            <p class="text-muted border p-3 rounded mt-1 bg-light"><?= $rekap && $rekap['tindak_lanjut'] ? nl2br(html_escape($rekap['tindak_lanjut'])) : 'Belum diisi wali kelas.' ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Riwayat Semester Sebelumnya -->
    <div class="card">
      <div class="card-header bg-dark text-white">
        <h3 class="card-title text-white"><i class="ti ti-history me-2"></i>Riwayat Perkembangan Semester Sebelumnya</h3>
      </div>
      <div class="card-body">
        <?php if (empty($riwayat_sebelumnya)): ?>
          <div class="text-center py-4 text-muted">Tidak ada riwayat perkembangan pada semester-semester sebelumnya.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Semester / Tahun</th>
                  <th>Kelas</th>
                  <th>Status</th>
                  <th>Kesimpulan Wali</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($riwayat_sebelumnya as $r): ?>
                  <tr>
                    <td><strong><?= html_escape($r['semester'] . ' ' . $r['tahun']) ?></strong></td>
                    <td><?= html_escape($r['nama_kelas']) ?></td>
                    <td><span class="badge bg-indigo-lt"><?= html_escape($r['status_perkembangan']) ?></span></td>
                    <td class="text-wrap" style="max-width: 300px;"><?= html_escape($r['kesimpulan_wali']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Chart Script -->
<script>
  $(document).ready(function() {
    var ctx = document.getElementById('aspectsRadarChart').getContext('2d');
    var radarChart = new Chart(ctx, {
      type: 'radar',
      data: {
        labels: ['Sikap & Perilaku', 'Keaktifan Belajar', 'Kedisiplinan', 'Motivasi Belajar'],
        datasets: [{
          label: 'Skor Rerata (Skala 1 - 4)',
          data: [
            <?= $chart_data['perilaku'] ?>,
            <?= $chart_data['keaktifan'] ?>,
            <?= $chart_data['kedisiplinan'] ?>,
            <?= $chart_data['motivasi'] ?>
          ],
          backgroundColor: 'rgba(99, 102, 241, 0.2)',
          borderColor: '#6366f1',
          pointBackgroundColor: '#6366f1',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: '#6366f1',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          r: {
            angleLines: { display: true },
            suggestedMin: 0,
            suggestedMax: 4,
            ticks: {
              stepSize: 1,
              font: { size: 9 }
            }
          }
        }
      }
    });
  });
</script>
