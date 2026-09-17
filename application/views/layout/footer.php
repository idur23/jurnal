        <footer class="footer footer-transparent d-print-none mt-auto">
          <div class="container-fluid">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-list-item">Status TP: <span class="badge bg-green-lt fw-bold"><?= isset($_active_tp['tahun']) ? $_active_tp['tahun'] . ' (' . $_active_tp['semester'] . ')' : 'Tidak Aktif' ?></span></li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; <?= date('Y') ?> <a href="#" class="link-secondary">Jurnal Guru Enterprise</a>. All rights reserved.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <!-- Tabler Core & Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      $(document).ready(function() {
        // CSRF Token Global Setup for AJAX
        var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

        $.ajaxSetup({
            data: { [csrfName]: csrfHash }
        });

        // DataTable Initialization
        if ($('.datatable').length) {
            $('.datatable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                "pageLength": 10,
                "responsive": true
            });
        }

        // Select2 Initialization
        if ($('.select2').length) {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Flatpickr Initialization
        if ($('.datepicker').length) {
            $('.datepicker').flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true
            });
        }

        // SweetAlert2 Flash Messages
        <?php if ($this->session->flashdata('success')): ?>
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= addslashes($this->session->flashdata('success')) ?>',
            timer: 2500,
            showConfirmButton: false
          });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
          Swal.fire({
            icon: 'error',
            title: 'Perhatian / Gagal!',
            text: '<?= addslashes($this->session->flashdata('error')) ?>',
            confirmButtonColor: '#6366f1'
          });
        <?php endif; ?>

        // Universal SweetAlert2 Handler for Delete Forms
        $(document).on('submit', 'form', function(e) {
            var form = this;
            var $form = $(form);
            var actionVal = $form.find('input[name="action"]').val();

            if (actionVal === 'delete') {
                if ($form.data('swal-confirmed')) {
                    return true;
                }

                e.preventDefault();

                var customMsg = $form.find('button[type="submit"]').data('confirm-msg') || 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.';

                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    text: customMsg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="ti ti-trash me-1"></i> Ya, Hapus Sekarang!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $form.data('swal-confirmed', true);
                        form.submit();
                    }
                });
            }
        });

        // Universal SweetAlert2 Handler for Delete Links
        $(document).on('click', 'a[href*="/delete/"], a.btn-delete', function(e) {
            var $this = $(this);
            if ($this.data('swal-confirmed')) {
                return true;
            }

            e.preventDefault();

            var customMsg = $this.data('confirm-msg') || 'Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.';

            Swal.fire({
                title: 'Konfirmasi Hapus Data',
                text: customMsg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash me-1"></i> Ya, Hapus Sekarang!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $this.attr('href');
                }
            });
        });

        // Universal SweetAlert2 Handler for Delete Supervisi Buttons
        $(document).on('click', '.btn-delete-supervisi', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var id = $btn.data('id');
            var name = $btn.data('name') || 'data supervisi ini';

            if (!id) return;

            Swal.fire({
                title: 'Hapus Supervisi Akademik?',
                text: 'Apakah Anda yakin ingin menghapus ' + name + '? Seluruh skor penilaian dan catatan instrumen ini akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="ti ti-trash me-1"></i> Ya, Hapus Permanen!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("supervisi/delete/") ?>' + id;
                }
            });
        });
      });
    </script>
  </body>
</html>
