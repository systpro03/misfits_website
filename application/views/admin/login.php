<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title); ?> — MISFITS RIDERS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Work+Sans:wght@400;500;600&display=swap"
      rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              asphalt: { 950: '#0E0F12', 900: '#17181C', 800: '#22242A', 700: '#33363E' },
              ember: { 500: '#E8580C', 600: '#C94807' },
              chrome: { 200: '#D8DBE0' },
            },
            fontFamily: { display: ['Oswald', 'ui-sans-serif', 'system-ui'], sans: ['Work Sans', 'ui-sans-serif', 'system-ui'] },
          }
        }
      }
    </script>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  </head>

  <body
    class="bg-asphalt-950 text-chrome-200 font-sans min-h-screen flex items-center justify-center px-5 relative overflow-hidden">

    <!-- Subtle Ambient Glow -->
    <div
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-ember-500/10 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="w-full max-w-md relative z-10">

      <!-- Logo & Branding Header -->
      <div class="flex flex-col items-center mb-8 text-center">
        <!-- Enlarged Logo Wrapper -->
        <div class="relative group mb-5">
          <img src="<?= base_url('assets/img/logo/misfits-logo.png'); ?>" alt="Misfits Riders emblem"
            class="h-44 w-auto object-contain drop-shadow-[0_10px_25px_rgba(232,88,12,0.25)] transition-transform duration-300 group-hover:scale-105">
        </div>

        <p class="font-display tracking-[0.35em] text-ember-500 text-xs font-semibold uppercase">MISFITS RIDERS</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-white mt-1">Admin Access</h1>
        <p class="text-xs text-chrome-200/50 mt-1">Enter your credentials to access the management portal</p>
      </div>

      <!-- Error Alert -->
      <?php if (!empty($error)): ?>
        <div
          class="bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs rounded-2xl px-4 py-3 mb-6 flex items-center gap-3 backdrop-blur-xs">
          <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span><?= $error; ?></span>
        </div>
      <?php endif; ?>

      <!-- Login Form Card -->
      <form action="<?= site_url('admin/login'); ?>" method="post"
        class="bg-asphalt-900/90 border border-asphalt-800/80 rounded-2xl p-7 shadow-2xl backdrop-blur-md space-y-5">

        <!-- Username Field -->
        <div>
          <label for="username"
            class="block text-xs font-semibold text-chrome-200/80 uppercase tracking-wider mb-2">Username</label>
          <div class="relative">
            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-chrome-200/40" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <input type="text" id="username" name="username" required autofocus placeholder="Enter your username"
              class="w-full bg-asphalt-950/80 border border-asphalt-800/80 rounded-xl pl-10 pr-4 py-3 text-xs text-white placeholder:text-chrome-200/30 focus:border-ember-500 focus:ring-2 focus:ring-ember-500/20 outline-none transition-all">
          </div>
        </div>

        <!-- Password Field -->
        <div>
          <label for="password"
            class="block text-xs font-semibold text-chrome-200/80 uppercase tracking-wider mb-2">Password</label>
          <div class="relative">
            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-chrome-200/40" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <input type="password" id="password" name="password" required placeholder="••••••••"
              class="w-full bg-asphalt-950/80 border border-asphalt-800/80 rounded-xl pl-10 pr-4 py-3 text-xs text-white placeholder:text-chrome-200/30 focus:border-ember-500 focus:ring-2 focus:ring-ember-500/20 outline-none transition-all">
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full py-3 bg-ember-500 hover:bg-ember-600 text-asphalt-950 font-display font-bold text-sm tracking-wider uppercase rounded-xl transition-all shadow-md active:scale-[0.98] mt-2 flex items-center justify-center gap-2">
          <span>Log In</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>
      </form>

      <!-- Navigation Link -->
      <p class="text-center mt-6">
        <a href="<?= base_url(); ?>"
          class="inline-flex items-center gap-1.5 text-xs text-chrome-200/50 hover:text-ember-500 transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span>Back to public site</span>
        </a>
      </p>

    </div>

  </body>

</html>