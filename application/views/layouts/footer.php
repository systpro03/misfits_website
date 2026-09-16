</main>

<!-- Footer Section -->
<footer class="bg-asphalt-950 text-white mt-20 border-t border-asphalt-800/40 relative">
  <!-- Subtle accent divider -->
  <div class="h-1 w-full bg-gradient-to-r from-asphalt-950 via-ember-500 to-asphalt-950"></div>

  <div class="max-w-6xl mx-auto px-5 py-16 grid grid-cols-1 md:grid-cols-3 gap-10">
    
    <!-- Brand Info -->
    <div class="space-y-4">
      <div class="flex items-center gap-3">
        <img src="<?= base_url('assets/img/logo/misfits-logo.png'); ?>" 
             alt="<?= htmlspecialchars($site->club_name ?? 'MISFITS RIDERS'); ?> Logo" 
             class="h-12 w-auto object-contain">
        <span class="font-display font-semibold text-lg text-white tracking-wide">
          <?= htmlspecialchars($site->club_name ?? 'MISFITS RIDERS'); ?>
        </span>
      </div>
      <?php if (!empty($site->tagline)): ?>
        <p class="text-xs md:text-sm text-asphalt-300 leading-relaxed max-w-xs">
          <?= htmlspecialchars($site->tagline); ?>
        </p>
      <?php endif; ?>
    </div>

    <!-- Quick Navigation Links -->
    <div>
      <h3 class="font-display text-xs font-semibold tracking-[0.2em] text-ember-500 uppercase mb-4">Ride With Us</h3>
      <ul class="space-y-2.5 text-xs md:text-sm text-asphalt-300">
        <li>
          <a href="<?= site_url('rides/upcoming'); ?>" class="hover:text-ember-400 transition-colors inline-flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-ember-500/50"></span>
            Upcoming Rides
          </a>
        </li>
        <li>
          <a href="<?= site_url('rides/past'); ?>" class="hover:text-ember-400 transition-colors inline-flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-asphalt-600"></span>
            Latest Rides
          </a>
        </li>
        <li>
          <a href="<?= site_url('members'); ?>" class="hover:text-ember-400 transition-colors inline-flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-asphalt-600"></span>
            Meet the Team
          </a>
        </li>
        <li>
          <a href="<?= site_url('gallery'); ?>" class="hover:text-ember-400 transition-colors inline-flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-asphalt-600"></span>
            Ride Gallery
          </a>
        </li>
      </ul>
    </div>

    <!-- Contact & Socials -->
    <div>
      <h3 class="font-display text-xs font-semibold tracking-[0.2em] text-ember-500 uppercase mb-4">Get in Touch</h3>
      <ul class="space-y-3 text-xs md:text-sm text-asphalt-300">
        <?php if (!empty($site->contact_email)): ?>
          <li class="flex items-center gap-2">
            <svg class="w-4 h-4 text-ember-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <a href="mailto:<?= htmlspecialchars($site->contact_email); ?>" class="hover:text-ember-400 transition-colors truncate">
              <?= htmlspecialchars($site->contact_email); ?>
            </a>
          </li>
        <?php endif; ?>

        <?php if (!empty($site->contact_phone)): ?>
          <li class="flex items-center gap-2">
            <svg class="w-4 h-4 text-ember-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            <span><?= htmlspecialchars($site->contact_phone); ?></span>
          </li>
        <?php endif; ?>

        <!-- Social Media Icons -->
        <li class="flex items-center gap-3 pt-2">
          <?php if (!empty($site->facebook_url)): ?>
            <a href="<?= htmlspecialchars($site->facebook_url); ?>" 
               class="p-2 rounded-lg bg-asphalt-900 hover:bg-ember-500 hover:text-asphalt-950 text-asphalt-300 transition-all border border-asphalt-800" 
               aria-label="Facebook" target="_blank" rel="noopener">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
              </svg>
            </a>
          <?php endif; ?>

          <?php if (!empty($site->instagram_url)): ?>
            <a href="<?= htmlspecialchars($site->instagram_url); ?>" 
               class="p-2 rounded-lg bg-asphalt-900 hover:bg-ember-500 hover:text-asphalt-950 text-asphalt-300 transition-all border border-asphalt-800" 
               aria-label="Instagram" target="_blank" rel="noopener">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </a>
          <?php endif; ?>
        </li>
      </ul>
    </div>

  </div>
<!-- Copyright Sub-Footer -->
  <div class="border-t border-asphalt-800/60 bg-asphalt-950/80 py-4">
    <div
      class="max-w-6xl mx-auto px-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-asphalt-400">
      <p>&copy; <?= date('Y'); ?> <strong class="text-white font-medium">
        <?= htmlspecialchars($site->club_name ?? 'MISFITS RIDERS'); ?>
      </strong>
      <?= !empty($site->founded_year) ? ' — Riding since ' . htmlspecialchars($site->founded_year) : ''; ?>
    </p>

    <!-- Site Visit Counter Badge -->
    <div
      class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-asphalt-900 border border-asphalt-800 text-[11px]">
      <svg class="w-3.5 h-3.5 text-ember-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      </svg>
      <strong class="font-display text-white tracking-wide">
        <?= number_format($total_visits ?? 0); ?>
      </strong>
    </div>

    <p class="italic text-asphalt-400">"We ride in peace."</p>
  </div>
</div>
</footer>

<!-- Back to Top -->
<a href="#page-top" id="back-to-top" aria-label="Back to top" title="Back to top" class="back-to-top-button">
  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
  </svg>
</a>

<?php $this->load->view('messages/widget'); ?>

<style>
  .back-to-top-button {
    position: fixed !important;
    right: 12px !important;
    bottom: 76px !important;
    z-index: 2147483647 !important;
    display: flex !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
    width: 54px !important;
    height: 54px !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
    background: #17181c !important;
    color: #fff !important;
    border: 1px solid rgba(232, 88, 12, .45) !important;
    box-shadow: 0 14px 35px rgba(0, 0, 0, .45) !important;
    text-decoration: none !important;
    transform: translateY(8px);
    transition: opacity .2s ease, transform .2s ease, background .2s ease !important;
  }

  .back-to-top-button.is-visible {
    visibility: visible !important;
    opacity: 1 !important;
    pointer-events: auto !important;
    transform: translateY(0);
  }

  .back-to-top-button:hover {
    background: #e8580c !important;
    color: #0e0f12 !important;
    transform: translateY(-2px);
  }

  @media (max-width: 767px) {
    .back-to-top-button {
      right: 12px !important;
      bottom: 76px !important;
      width: 52px !important;
      height: 52px !important;
    }
  }
</style>

<script>
  window.MISFITS_CHAT_BASE = <?= json_encode(rtrim(site_url(), '/') . '/'); ?>;
</script>


<!-- Scripts -->
<script>
  document.getElementById('menu-toggle')?.addEventListener('click', function () {
    var menu = document.getElementById('mobile-menu');
    var expanded = this.getAttribute('aria-expanded') === 'true';
    this.setAttribute('aria-expanded', String(!expanded));
    menu?.classList.toggle('hidden');
  });

  (function () {
    var button = document.getElementById('back-to-top');
    if (!button) return;

    function updateBackToTop() {
      button.classList.toggle('is-visible', window.scrollY > 300);
    }

    window.addEventListener('scroll', updateBackToTop, { passive: true });
    updateBackToTop();
  })();
</script>
</body>
</html>