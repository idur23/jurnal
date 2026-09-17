<div class="page-header d-print-none mb-4">
  <div class="row align-items-center">
    <div class="col">
      <h2 class="page-title">Audit Trail Activity Logs</h2>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-vcenter card-table datatable table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Waktu Log</th>
          <th>User / Role</th>
          <th>Action Code</th>
          <th>Deskripsi Aktivitas</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach ($logs as $l): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td class="text-muted small"><?= $l['created_at'] ?></td>
            <td>
              <div class="fw-bold"><?= html_escape($l['full_name'] ?? 'System') ?></div>
              <div class="text-muted small"><?= html_escape($l['role_name'] ?? 'Guest') ?></div>
            </td>
            <td><span class="badge bg-blue-lt"><code><?= html_escape($l['action']) ?></code></span></td>
            <td><?= html_escape($l['description']) ?></td>
            <td><code><?= html_escape($l['ip_address']) ?></code></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
