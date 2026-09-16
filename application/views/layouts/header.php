<?php

$current_path = trim(parse_url($_SERVER[ 'REQUEST_URI' ], PHP_URL_PATH), '/');

$base_path = trim(parse_url(base_url(), PHP_URL_PATH), '/');
if ($base_path && strpos($current_path, $base_path) === 0) {
  $current_path = trim(substr($current_path, strlen($base_path)), '/');
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'MISFITS RIDERS'; ?></title>
    

    <meta name="description"
      content="<?= htmlspecialchars(isset($site->tagline) ? $site->tagline : 'A motorcycle riding group built on brotherhood and the open road.'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap"
      rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/logo/misfits-logo.png'); ?>" type="image/png">

    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <script src="<?php echo base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/toastr.css') ?>">
    <script src="<?php echo base_url('assets/js/toastr.min.js') ?>"></script>
    <script defer src="<?php echo base_url('assets/js/alpine.js') ?>"></script>
  </head>

  <body class="bg-paper-50 text-asphalt-900 antialiased">

    <!-- Removed border-b border-asphalt-800 and the bottom road-divider div -->
    <header class="bg-asphalt-950 text-chrome-200 sticky top-0 z-50">
      <div class="max-w-6xl mx-auto px-5">
        <div class="flex items-center justify-between h-16">
          <a href="<?= base_url(); ?>" class="flex items-center gap-3 group">
            <img src="<?= base_url('assets/img/logo/misfits-logo.png'); ?>" alt="Misfits Riders emblem"
              class="h-10 w-10">
            <span class="font-display font-semibold text-lg tracking-wide">
              <?= htmlspecialchars(isset($site->club_name) ? $site->club_name : 'MISFITS RIDERS'); ?>
            </span>
          </a>

          <nav class="hidden md:flex items-center gap-8 font-display text-sm tracking-wide">
            <a href="<?= base_url(); ?>"
              class="hover:text-ember-500 transition-colors <?= ($current_path == '' || $current_path == base_url()) ? 'text-ember-500 font-medium' : 'text-chrome-200'; ?>">Home</a>
            <a href="<?= site_url('rides'); ?>"
              class="hover:text-ember-500 transition-colors <?= (strpos($current_path, 'rides') === 0) ? 'text-ember-500 font-medium' : 'text-chrome-200'; ?>">Rides</a>
            <a href="<?= site_url('members'); ?>"
              class="hover:text-ember-500 transition-colors <?= ($current_path == 'members') ? 'text-ember-500 font-medium' : 'text-chrome-200'; ?>">Team</a>
            <a href="<?= site_url('gallery'); ?>"
              class="hover:text-ember-500 transition-colors <?= ($current_path == 'gallery') ? 'text-ember-500 font-medium' : 'text-chrome-200'; ?>">Gallery</a>
            <a href="<?= site_url('about'); ?>"
              class="hover:text-ember-500 transition-colors <?= ($current_path == 'about') ? 'text-ember-500 font-medium' : 'text-chrome-200'; ?>">About</a>
            <a href="<?= site_url('contact'); ?>"
              class="hover:text-ember-500 transition-colors <?= ($current_path == 'contact') ? 'text-ember-500 font-medium' : 'text-chrome-200'; ?>">Contact</a>
            <a href="<?= site_url('admin'); ?>"
              class="ml-2 px-4 py-2 rounded border border-ember-500 text-ember-500 hover:bg-ember-500 hover:text-asphalt-950 transition-colors">Admin</a>
          </nav>

          <button id="menu-toggle" class="md:hidden p-2 -mr-2" aria-label="Toggle menu" aria-expanded="false"
            aria-controls="mobile-menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <nav id="mobile-menu" class="md:hidden hidden pb-4 font-display text-sm tracking-wide flex flex-col gap-3 pt-3">
          <a href="<?= base_url(); ?>"
            class="py-1 hover:text-ember-500 transition-colors <?= ($current_path == '' || $current_path == base_url()) ? 'text-ember-500 font-medium' : ''; ?>">Home</a>
          <a href="<?= site_url('rides'); ?>"
            class="py-1 hover:text-ember-500 transition-colors <?= (strpos($current_path, 'rides') === 0) ? 'text-ember-500 font-medium' : ''; ?>">Rides</a>
          <a href="<?= site_url('members'); ?>"
            class="py-1 hover:text-ember-500 transition-colors <?= ($current_path == 'members') ? 'text-ember-500 font-medium' : ''; ?>">Team</a>
          <a href="<?= site_url('gallery'); ?>"
            class="py-1 hover:text-ember-500 transition-colors <?= ($current_path == 'gallery') ? 'text-ember-500 font-medium' : ''; ?>">Gallery</a>
          <a href="<?= site_url('about'); ?>"
            class="py-1 hover:text-ember-500 transition-colors <?= ($current_path == 'about') ? 'text-ember-500 font-medium' : ''; ?>">About</a>
          <a href="<?= site_url('contact'); ?>"
            class="py-1 hover:text-ember-500 transition-colors <?= ($current_path == 'contact') ? 'text-ember-500 font-medium' : ''; ?>">Contact</a>
          <a href="<?= site_url('admin'); ?>" class="py-1 text-ember-500 font-semibold">Admin</a>
        </nav>
      </div>
    </header>

    <main>
      <?php if (function_exists('flash_message') && flash_message()): ?>
        <div class="max-w-6xl mx-auto px-5 pt-6"><?= flash_message(); ?></div>
      <?php endif; ?>