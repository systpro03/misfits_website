<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title); ?> — MISFITS RIDERS Admin</title>
<link rel="icon" type="image/png" href="<?= base_url('assets/img/logo/misfits-logo.png?v=3') ?>">
<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/logo/misfits-logo.png?v=3') ?>">
<link rel="apple-touch-icon" href="<?= base_url('assets/img/logo/misfits-logo.png?v=3') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/modern-ui.css') ?>">
    <script src="<?php echo base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/toastr.css') ?>">
    <script src="<?php echo base_url('assets/js/toastr.min.js') ?>"></script>
    <script defer src="<?php echo base_url('assets/js/alpine.js') ?>"></script>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.min.css') ?>">
    <style>
      [x-cloak] {
        display: none !important;
      }
    </style>

        <!-- Chart.js CDN -->
    <style>
      .dataTables_wrapper {
        color: #9ca3af;
        font-size: 0.75rem;
        padding: 1rem;
      }

      .dataTables_wrapper .dataTables_length select,
      .dataTables_wrapper .dataTables_filter input {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
        color: #000000;
        padding: 0.25rem 0.5rem;
        outline: none;
      }

      .dataTables_wrapper .dataTables_length select:focus,
      .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #3b82f6;
      }

      .dataTables_wrapper .dataTables_info {
        color: #9ca3af;
        padding-top: 0.75rem;
      }

      .dataTables_wrapper .dataTables_paginate {
        padding-top: 0.75rem;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #9ca3af !important;
        border-radius: 0.375rem !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        background: rgba(255, 255, 255, 0.05) !important;
        padding: 0.2rem 0.6rem !important;
        margin-left: 0.25rem !important;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button.current,
      .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #3b82f6 !important;
        color: #ffffff !important;
        border-color: transparent !important;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
      .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.3;
        cursor: not-allowed;
      }

      table.dataTable.no-footer {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }
    </style>
  </head>

  <body class="bg-paper-50 text-asphalt-900 font-sans">

    <div class="flex min-h-screen">
      <!-- ==================== DESKTOP SIDEBAR ==================== -->
      <aside
        class="hidden lg:flex flex-col w-64 bg-asphalt-950 text-chrome-200 flex-shrink-0 h-screen sticky top-0 border-r border-asphalt-800/60">

        <!-- Brand / Logo Header (Fixed top) -->
        <div class="flex items-center gap-3 px-6 h-16 border-b border-asphalt-800/80 flex-shrink-0 bg-asphalt-950">
          <img src="<?= base_url('assets/img/logo/misfits-logo.png'); ?>" alt="Misfits Logo" class="h-12 w-14">
          <span class="font-display font-bold tracking-wider text-sm text-white">MISFITS ADMIN</span>
        </div>

        <!-- Scrollable Navigation Area -->
        <div class="flex-1 overflow-y-auto px-3 py-6 space-y-1.5 font-display text-sm tracking-wide custom-scrollbar">
          <?php
          $nav_items = array(
            array('admin/dashboard', 'Dashboard', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>'),
            array('admin/announcements', 'Announcements', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5H5a2 2 0 00-2 2v9a2 2 0 002 2h3l4 3 4-3h3a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h7"/></svg>'),
            array('admin/rides', 'Rides', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'),
            array('admin/routes', 'Routes', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>'),
            array('admin/members', 'Members', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'),
            array('admin/gallery', 'Gallery', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'),
            array('admin/requests', 'Photo Requests', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>'),
            array('admin/index', 'Chat Messages', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8M8 14h5m7-2a8 8 0 01-8 8 8.5 8.5 0 01-3.8-.9L4 20l.9-3.2A8 8 0 0112 20z"/></svg>'),
            array('admin/settings', 'Site Settings', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'),
          );
          $current = uri_string();
          ?>

          <?php foreach ($nav_items as $item):
            $active = (strpos($current, $item[ 0 ]) === 0) || ($item[ 0 ] === 'admin/dashboard' && in_array($current, array('admin', ''), TRUE));
            ?>
            <a href="<?= base_url($item[ 0 ]); ?>"
              class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all group <?= $active ? 'bg-ember-500 text-asphalt-950 font-bold shadow-xs' : 'hover:bg-asphalt-900 text-chrome-200/70 hover:text-white'; ?>">

              <div class="flex items-center gap-3">
                <span
                  class="<?= $active ? 'text-asphalt-950' : 'text-chrome-200/50 group-hover:text-ember-500 transition-colors'; ?>">
                  <?= $item[ 2 ]; ?>
                </span>
                <span><?= $item[ 1 ]; ?></span>
              </div>

              <?php if ($item[ 0 ] === 'admin/requests' && !empty($pending_requests_count)): ?>
                <span class="text-xs font-bold rounded-full px-2 py-0.5 transition-colors <?= $active ? 'bg-asphalt-950 text-ember-500' : 'bg-ember-500/20 text-ember-500 group-hover:bg-ember-500 group-hover:text-white'; ?>">
                  <?= (int) $pending_requests_count; ?>
                </span>
              <?php elseif ($item[ 0 ] === 'admin/index' && !empty($chat_unread_count)): ?>
                <span class="text-xs font-bold rounded-full px-2 py-0.5 transition-colors <?= $active ? 'bg-asphalt-950 text-ember-500' : 'bg-ember-500/20 text-ember-500 group-hover:bg-ember-500 group-hover:text-white'; ?>">
                  <?= (int) $chat_unread_count > 99 ? '99+' : (int) $chat_unread_count; ?>
                </span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- Admin Profile Footer (Fixed bottom) -->
        <div
          class="px-5 py-4 border-t border-asphalt-800/80 bg-asphalt-950 flex-shrink-0 flex items-center justify-between">
          <div class="min-w-0 pr-2">
            <p class="text-[10px] uppercase font-semibold text-chrome-200/40 tracking-wider">Logged in as</p>
            <p class="text-xs font-bold text-white truncate mt-0.5"><?= htmlspecialchars($admin[ 'full_name' ]); ?></p>
          </div>
          <a href="<?= base_url('admin/logout'); ?>"
            class="p-2 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-lg transition-colors flex-shrink-0"
            title="Log out">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </a>
        </div>
      </aside>

      <!-- ==================== MAIN COLUMN ==================== -->
      <div class="flex-1 min-w-0 flex flex-col">
        <!-- Mobile top bar -->
        <div
          class="lg:hidden flex items-center justify-between bg-asphalt-950 text-chrome-200 h-14 px-4 sticky top-0 z-30 border-b border-asphalt-800">
          <div class="flex items-center gap-2">
            <img src="<?= base_url('assets/img/logo/misfits-logo.png'); ?>" alt="" class="h-7 w-7">
            <span class="font-display font-bold text-sm tracking-wide text-white">MISFITS ADMIN</span>
          </div>
          <button id="mobile-admin-toggle" class="p-2 text-chrome-200 hover:text-white" aria-label="Menu"
            aria-expanded="false" aria-controls="mobile-admin-menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <!-- Mobile Nav Menu Dropdown -->
        <nav id="mobile-admin-menu"
          class="hidden lg:hidden bg-asphalt-900 text-chrome-200 px-4 py-3 space-y-1 font-display text-sm border-b border-asphalt-800">
          <?php foreach ($nav_items as $item): ?>
            <a href="<?= base_url($item[ 0 ]); ?>" class="flex items-center justify-between py-2 text-chrome-200/80 hover:text-white">
              <span class="flex items-center gap-3"><span class="text-ember-500"><?= $item[ 2 ]; ?></span><span><?= $item[ 1 ]; ?></span></span>
              <?php if ($item[ 0 ] === 'admin/index' && !empty($chat_unread_count)): ?><span class="text-[10px] font-bold bg-ember-500/20 text-ember-500 rounded-full px-2 py-0.5"><?= (int) $chat_unread_count > 99 ? '99+' : (int) $chat_unread_count; ?></span><?php endif; ?>
            </a>
          <?php endforeach; ?>
          <a href="<?= base_url('admin/logout'); ?>"
            class="flex items-center gap-3 py-2 text-rose-400 hover:text-rose-300 pt-3 border-t border-asphalt-800/60">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Log out</span>
          </a>
        </nav>

        <header class="bg-white border-b border-asphalt-800/10 h-16 flex items-center px-6 lg:px-8">
          <h1 class="font-display text-xl font-semibold text-asphalt-900"><?= htmlspecialchars($title); ?></h1>
        </header>

        <main class="p-6 lg:p-8 flex-1">
          <?php if (function_exists('flash_message') && flash_message()): ?>
            <?= flash_message(); ?>
          <?php endif; ?>