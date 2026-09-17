<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= isset($title) ? html_escape($title) . ' - ' : '' ?><?= html_escape($_settings['app_name'] ?? 'Jurnal Guru Enterprise') ?></title>
    
    <!-- Dynamic Favicon -->
    <?php if (!empty($_settings['app_favicon']) && file_exists('./' . $_settings['app_favicon'])): ?>
      <link rel="shortcut icon" href="<?= base_url($_settings['app_favicon']) ?>?v=<?= time() ?>" type="image/x-icon">
    <?php else: ?>
      <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico') ?>" type="image/x-icon">
    <?php endif; ?>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tabler Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler-vendors.min.css">
    <!-- Tabler Icons (Local Assets + CDN Fallback) -->
    <?php if (file_exists('./assets/css/tabler-icons.min.css')): ?>
      <link rel="stylesheet" href="<?= base_url('assets/css/tabler-icons.min.css') ?>?v=<?= time() ?>">
    <?php else: ?>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <?php endif; ?>

    <!-- Third-party Vendors CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- jQuery First -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
      :root {
      	--tblr-font-sans-serif: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif;
        --tblr-primary: #6366f1;
        --tblr-primary-gradient: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
        --glass-card: rgba(30, 41, 59, 0.75);
        --glass-border: rgba(255, 255, 255, 0.12);
      }

      body {
        font-family: var(--tblr-font-sans-serif) !important;
        transition: background 0.3s ease, color 0.3s ease;
        min-height: 100vh;
      }

      /* SIDEBAR SUBMENU DROPDOWN STYLING (FIX BLACK TEXT IN DROPDOWN) */
      aside.navbar-vertical .dropdown-menu {
        background-color: rgba(30, 41, 59, 0.95) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 12px !important;
        padding: 0.5rem !important;
        margin-top: 0.25rem !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4) !important;
      }

      aside.navbar-vertical .dropdown-item {
        color: #e2e8f0 !important;
        font-weight: 500 !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
      }

      aside.navbar-vertical .dropdown-item:hover {
        background-color: rgba(99, 102, 241, 0.25) !important;
        color: #ffffff !important;
        padding-left: 1.1rem !important;
      }

      aside.navbar-vertical .dropdown-item.active {
        background: var(--tblr-primary-gradient) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4) !important;
      }

      /* ==================== TEMA CERAH ENTERPRISE ==================== */
      body, body.theme-light {
        background: #f1f5f9 !important;
        color: #0f172a !important;
        --tblr-bg-surface: #ffffff !important;
        --tblr-card-bg: #ffffff !important;
      }

      body.theme-light .page-title { color: #0f172a !important; font-weight: 700; }
      body.theme-light .page-pretitle { color: #64748b !important; text-transform: uppercase; }
      body.theme-light .text-muted { color: #64748b !important; }
      body.theme-light .subheader { color: #475569 !important; font-weight: 600; }
      body.theme-light .form-label { color: #0f172a !important; font-weight: 600; }

      body.theme-light .card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
      }

      body.theme-light .card-header {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
      }

      body.theme-light .card-title { color: #0f172a !important; }

      body.theme-light header.navbar {
        background: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
        color: #0f172a !important;
      }

      /* STRICT TABLER CARD-TABLE & STRIPED OVERRIDES IN LIGHT THEME */
      body.theme-light .table,
      body.theme-light .card-table,
      body.theme-light .card-table tr,
      body.theme-light .card-table td,
      body.theme-light .card-table th {
        background-color: transparent !important;
        color: #0f172a !important;
      }

      body.theme-light .table thead th,
      body.theme-light .card-table thead th {
        background: #e2e8f0 !important;
        color: #334155 !important;
        border-bottom: 1px solid #cbd5e1 !important;
        font-weight: 700;
      }

      body.theme-light .table .fw-bold,
      body.theme-light .card-table .fw-bold { color: #0f172a !important; }

      body.theme-light .table .text-muted,
      body.theme-light .card-table .text-muted,
      body.theme-light .table small,
      body.theme-light .card-table small {
        color: #64748b !important;
      }

      body.theme-light .table a:not(.btn),
      body.theme-light .card-table a:not(.btn) {
        color: #4f46e5 !important;
        font-weight: 600;
      }

      body.theme-light .table code,
      body.theme-light .card-table code {
        background: #e0e7ff !important;
        color: #3730a3 !important;
        border: 1px solid #c7d2fe !important;
        border-radius: 4px;
        padding: 2px 6px;
      }

      /* STRIPED EVEN & ODD ROWS OVERRIDE LIGHT */
      body.theme-light .table-striped > tbody > tr:nth-of-type(odd),
      body.theme-light .table-striped > tbody > tr:nth-of-type(odd) > *,
      body.theme-light .card-table tbody tr:nth-of-type(odd),
      body.theme-light .card-table tbody tr:nth-of-type(odd) > *,
      body.theme-light table.dataTable tbody tr.odd,
      body.theme-light table.dataTable tbody tr.odd > * {
        background-color: #ffffff !important;
        color: #0f172a !important;
      }

      body.theme-light .table-striped > tbody > tr:nth-of-type(even),
      body.theme-light .table-striped > tbody > tr:nth-of-type(even) > *,
      body.theme-light .card-table tbody tr:nth-of-type(even),
      body.theme-light .card-table tbody tr:nth-of-type(even) > *,
      body.theme-light table.dataTable tbody tr.even,
      body.theme-light table.dataTable tbody tr.even > * {
        background-color: #f8fafc !important;
        color: #0f172a !important;
      }

      body.theme-light .table-hover > tbody > tr:hover,
      body.theme-light .table-hover > tbody > tr:hover > *,
      body.theme-light .card-table tbody tr:hover,
      body.theme-light .card-table tbody tr:hover > * {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
      }

      body.theme-light .table td,
      body.theme-light .card-table td { border-bottom: 1px solid #e2e8f0 !important; }

      /* Form Controls Light */
      body.theme-light .form-control, body.theme-light .form-select {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
      }

      body.theme-light .form-control::placeholder { color: #94a3b8 !important; }

      body.theme-light .select2-container--bootstrap-5 .select2-selection {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
      }

      body.theme-light .select2-container--bootstrap-5 .select2-selection__rendered { color: #0f172a !important; }

      body.theme-light .select2-dropdown {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
      }

      body.theme-light .modal-content {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
      }

      body.theme-light .modal-header, body.theme-light .modal-footer {
        border-color: #e2e8f0 !important;
      }

      /* Common Shared Elements */
      .btn-primary {
        background: var(--tblr-primary-gradient) !important;
        border: none !important;
        box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.4) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
      }

      aside.navbar-vertical {
        background: rgba(15, 23, 42, 0.95) !important;
        backdrop-filter: blur(20px);
        border-right: 1px solid var(--glass-border) !important;
      }

      .navbar-dark .nav-link {
        color: #94a3b8 !important;
        font-weight: 600;
        padding: 0.75rem 1rem;
        border-radius: 10px;
      }

      .navbar-dark .nav-link-title { color: #cbd5e1 !important; }
      .navbar-dark .nav-link-icon { color: #818cf8 !important; font-size: 1.25rem; }

      .navbar-dark .nav-item.active > .nav-link,
      .navbar-dark .nav-link:hover {
        background: rgba(99, 102, 241, 0.15) !important;
        color: #ffffff !important;
      }

      .badge {
        border-radius: 20px !important;
        padding: 0.35em 0.8em !important;
        font-weight: 700 !important;
      }

      /* ==================== RESPONSIVE & MOBILE OPTIMIZATIONS ==================== */
      @media (min-width: 992px) {
        .border-bottom-lg {
          border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
          width: 100% !important;
        }
      }

      @media (max-width: 991.98px) {
        aside.navbar-vertical {
          position: sticky;
          top: 0;
          z-index: 1030;
          border-right: none !important;
          border-bottom: 1px solid var(--glass-border) !important;
          box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        aside.navbar-vertical .container-fluid {
          display: flex;
          flex-wrap: nowrap;
          align-items: center;
          justify-content: space-between;
          min-height: 60px;
        }

        aside.navbar-vertical .navbar-toggler {
          display: inline-flex !important;
          align-items: center;
          justify-content: center;
          padding: 0.35rem 0.6rem !important;
          border: 1px solid rgba(255, 255, 255, 0.25) !important;
          border-radius: 10px !important;
          background: rgba(255, 255, 255, 0.1) !important;
          color: #ffffff !important;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
          cursor: pointer;
        }

        body.theme-light aside.navbar-vertical .navbar-toggler {
          border: 1px solid rgba(0, 0, 0, 0.2) !important;
          background: rgba(0, 0, 0, 0.05) !important;
          color: #0f172a !important;
        }

        .brand-wrapper {
          border-bottom: none !important;
          padding: 0 !important;
          margin: 0 !important;
        }

        aside.navbar-vertical .navbar-collapse {
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background: #0f172a !important;
          border-bottom: 1px solid var(--glass-border) !important;
          padding: 1rem 1.25rem !important;
          max-height: 80vh;
          overflow-y: auto;
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.6) !important;
        }

        body.theme-light aside.navbar-vertical .navbar-collapse {
          background: #ffffff !important;
          border-bottom: 1px solid #e2e8f0 !important;
        }

        .page-wrapper {
          padding-top: 0 !important;
        }
      }

      @media (max-width: 575.98px) {
        .page-body {
          padding-left: 0.75rem !important;
          padding-right: 0.75rem !important;
          padding-top: 0.75rem !important;
        }

        .page-header {
          margin-bottom: 1rem !important;
        }

        .page-title {
          font-size: 1.25rem !important;
          line-height: 1.3 !important;
        }

        .card-body {
          padding: 0.85rem !important;
        }

        .card-header {
          padding: 0.75rem 0.85rem !important;
        }

        .table th, .table td {
          padding: 0.5rem 0.6rem !important;
          font-size: 0.8125rem !important;
        }

        .badge {
          font-size: 0.7rem !important;
        }

        .btn {
          font-size: 0.875rem !important;
        }

        .btn-list {
          gap: 0.25rem !important;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
          text-align: center !important;
          float: none !important;
          margin-top: 0.5rem !important;
        }
      }

      /* Global Select2 Mobile Responsiveness */
      .select2-container {
        width: 100% !important;
      }

      /* Touch smooth scroll for tables */
      .table-responsive {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto;
      }
    </style>
  </head>
  <body class="layout-fluid theme-light">
    <div class="page">
