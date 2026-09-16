<!-- ================= PAGE HEADER ================= -->
<section class="relative bg-asphalt-950 text-chrome-200 py-10 md:py-14 overflow-hidden border-b border-asphalt-800/80">
  <!-- Subtle Speed Line Accents -->
  <div class="absolute inset-y-0 right-[-10%] w-1/2 bg-ember-500/10 -skew-x-12 pointer-events-none blur-2xl"></div>
  <div
    class="absolute top-1/2 left-0 -translate-y-1/2 w-60 h-60 bg-ember-500/5 rounded-full blur-3xl pointer-events-none">
  </div>

  <div class="relative max-w-6xl mx-auto px-5">
    <p class="font-display text-ember-500 tracking-[0.25em] text-[11px] font-bold uppercase mb-1.5">GET IN TOUCH</p>
    <h1 class="font-display font-bold text-3xl sm:text-4xl max-w-3xl leading-tight text-white tracking-tight">
      Contact Us
    </h1>
  </div>
</section>

<!-- ================= CONTACT GRID & INFO ================= -->
<section class="max-w-4xl mx-auto px-5 py-10 md:py-12">
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

    <!-- Email Card -->
    <?php if (!empty($site->contact_email)): ?>
      <a href="mailto:<?= htmlspecialchars($site->contact_email); ?>"
        class="group bg-white border border-asphalt-800/10 rounded-xl p-5 hover:border-ember-500/40 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
        <div>
          <div
            class="w-8 h-8 rounded-lg bg-ember-500/10 text-ember-600 flex items-center justify-center mb-3 group-hover:bg-ember-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
          <p class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase mb-1">Email</p>
          <p
            class="text-sm sm:text-base font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors duration-200 break-all">
            <?= htmlspecialchars($site->contact_email); ?>
          </p>
        </div>
        <span
          class="inline-flex items-center gap-1 text-[11px] font-display font-semibold text-asphalt-700/60 group-hover:text-ember-600 mt-4 transition-colors duration-200">
          Send a message &rarr;
        </span>
      </a>
    <?php endif; ?>

    <!-- Phone Card -->
    <?php if (!empty($site->contact_phone)): ?>
      <a href="tel:<?= htmlspecialchars($site->contact_phone); ?>"
        class="group bg-white border border-asphalt-800/10 rounded-xl p-5 hover:border-ember-500/40 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
        <div>
          <div
            class="w-8 h-8 rounded-lg bg-ember-500/10 text-ember-600 flex items-center justify-center mb-3 group-hover:bg-ember-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </div>
          <p class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase mb-1">Phone</p>
          <p
            class="text-sm sm:text-base font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors duration-200">
            <?= htmlspecialchars($site->contact_phone); ?>
          </p>
        </div>
        <span
          class="inline-flex items-center gap-1 text-[11px] font-display font-semibold text-asphalt-700/60 group-hover:text-ember-600 mt-4 transition-colors duration-200">
          Call us direct &rarr;
        </span>
      </a>
    <?php endif; ?>

    <!-- Facebook Card -->
    <?php if (!empty($site->facebook_url)): ?>
      <a href="<?= htmlspecialchars($site->facebook_url); ?>" target="_blank" rel="noopener"
        class="group bg-white border border-asphalt-800/10 rounded-xl p-5 hover:border-ember-500/40 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
        <div>
          <div
            class="w-8 h-8 rounded-lg bg-ember-500/10 text-ember-600 flex items-center justify-center mb-3 group-hover:bg-ember-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
          </div>
          <p class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase mb-1">Facebook</p>
          <p
            class="text-sm sm:text-base font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors duration-200">
            Official Facebook Page
          </p>
        </div>
        <span
          class="inline-flex items-center gap-1 text-[11px] font-display font-semibold text-asphalt-700/60 group-hover:text-ember-600 mt-4 transition-colors duration-200">
          Visit page &rarr;
        </span>
      </a>
    <?php endif; ?>

    <!-- Instagram Card -->
    <?php if (!empty($site->instagram_url)): ?>
      <a href="<?= htmlspecialchars($site->instagram_url); ?>" target="_blank" rel="noopener"
        class="group bg-white border border-asphalt-800/10 rounded-xl p-5 hover:border-ember-500/40 hover:shadow-md transition-all duration-300 flex flex-col justify-between">
        <div>
          <div
            class="w-8 h-8 rounded-lg bg-ember-500/10 text-ember-600 flex items-center justify-center mb-3 group-hover:bg-ember-500 group-hover:text-white transition-colors duration-300">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
            </svg>
          </div>
          <p class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase mb-1">Instagram</p>
          <p
            class="text-sm sm:text-base font-bold text-asphalt-900 group-hover:text-ember-600 transition-colors duration-200">
            Official Instagram
          </p>
        </div>
        <span
          class="inline-flex items-center gap-1 text-[11px] font-display font-semibold text-asphalt-700/60 group-hover:text-ember-600 mt-4 transition-colors duration-200">
          Visit profile &rarr;
        </span>
      </a>
    <?php endif; ?>

  </div>

  <!-- Note Box -->
  <div class="mt-5 p-5 bg-paper-50 border-l-4 border-l-ember-500 border border-asphalt-800/10 rounded-xl shadow-xs">
    <p class="text-asphalt-900 leading-snug font-sans text-sm">
      <strong class="font-display font-bold text-asphalt-950">Want to join a ride or have a question?</strong><br>
      Reach out through any of the channels above — a Road Captain or club officer will get back to you as soon as
      possible.
    </p>
  </div>
</section>