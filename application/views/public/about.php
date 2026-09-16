<!-- ================= PAGE HEADER ================= -->
<section class="relative bg-asphalt-950 text-chrome-200 py-10 md:py-14 overflow-hidden border-b border-asphalt-800/80">
  <!-- Subtle Speed Line Accents -->
  <div class="absolute inset-y-0 right-[-10%] w-1/2 bg-ember-500/10 -skew-x-12 pointer-events-none blur-2xl"></div>
  <div
    class="absolute top-1/2 left-0 -translate-y-1/2 w-60 h-60 bg-ember-500/5 rounded-full blur-3xl pointer-events-none">
  </div>

  <div class="relative max-w-6xl mx-auto px-5">
    <p class="font-display text-ember-500 tracking-[0.25em] text-[11px] font-bold uppercase mb-1.5">WHO WE ARE</p>
    <h1 class="font-display font-bold text-3xl sm:text-4xl max-w-3xl leading-tight text-white tracking-tight">
      About <?= htmlspecialchars($site->club_name); ?>
    </h1>
  </div>
</section>

<!-- ================= MAIN ABOUT TEXT ================= -->
<section class="max-w-4xl mx-auto px-5 py-8 md:py-12">
  <div class="prose prose-base prose-invert max-w-none">
    <p class="text-base md:text-lg leading-relaxed text-asphalt-900/90 font-sans font-normal whitespace-pre-line">
      <?= htmlspecialchars($site->about_text); ?>
    </p>
  </div>
</section>

<!-- ================= VISION / MISSION CARDS ================= -->
<section class="bg-paper-50 border-y border-asphalt-800/10 py-10 md:py-12">
  <div class="max-w-6xl mx-auto px-5 grid grid-cols-1 md:grid-cols-2 gap-5">

    <!-- Vision Card -->
    <div
      class="bg-white p-5 md:p-6 rounded-xl border border-asphalt-800/10 shadow-xs hover:border-ember-500/40 transition-all duration-300 relative overflow-hidden group">
      <div class="absolute top-0 left-0 w-full h-1 bg-ember-500"></div>
      <div class="flex items-center gap-2.5 mb-3">
        <div class="w-8 h-8 rounded-lg bg-ember-500/10 text-ember-600 flex items-center justify-center font-bold">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
        </div>
        <h2 class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase">Our Vision</h2>
      </div>
      <p class="text-sm md:text-base font-display leading-snug text-asphalt-900 font-semibold">
        <?= htmlspecialchars($site->vision_text); ?>
      </p>
    </div>

    <!-- Mission Card -->
    <div
      class="bg-white p-5 md:p-6 rounded-xl border border-asphalt-800/10 shadow-xs hover:border-ember-500/40 transition-all duration-300 relative overflow-hidden group">
      <div class="absolute top-0 left-0 w-full h-1 bg-ember-500"></div>
      <div class="flex items-center gap-2.5 mb-3">
        <div class="w-8 h-8 rounded-lg bg-ember-500/10 text-ember-600 flex items-center justify-center font-bold">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
        </div>
        <h2 class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase">Our Mission</h2>
      </div>
      <p class="text-sm md:text-base font-display leading-snug text-asphalt-900 font-semibold">
        <?= htmlspecialchars($site->mission_text); ?>
      </p>
    </div>

  </div>
</section>

<!-- ================= RIDERS ROSTER (6 PER ROW) ================= -->
<section class="max-w-6xl mx-auto px-5 py-10 md:py-14">
  <div class="mb-6">
    <p class="font-display text-[11px] font-bold tracking-[0.2em] text-ember-600 uppercase mb-1">The Riders</p>
    <p class="font-display text-2xl md:text-3xl font-bold text-asphalt-900">Everyone in Formation</p>
  </div>

  <?php if (empty($members)): ?>
    <div class="bg-paper-50 p-6 rounded-xl border border-asphalt-800/10 text-center">
      <p class="text-asphalt-700/60 font-display text-xs tracking-wide">Roster coming soon.</p>
    </div>
  <?php else: ?>
    <!-- Displaying 6 columns on desktop -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
      <?php foreach ($members as $m): ?>
        <div class="text-center group p-2">
          <div
            class="relative w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full overflow-hidden bg-asphalt-900 mb-2 border-2 border-asphalt-800/10 group-hover:border-ember-500 transition-colors duration-300 shadow-xs">
            <img src="<?= upload_url('members', $m->image); ?>" alt="<?= htmlspecialchars($m->full_name); ?>"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

            <!-- Fallback initials avatar -->
            <div
              class="hidden absolute inset-0 flex items-center justify-center bg-asphalt-900 text-ember-500 font-display font-bold text-sm sm:text-base">
              <?= strtoupper(substr($m->road_name ?: $m->full_name, 0, 2)); ?>
            </div>
          </div>
          <p class="font-display font-bold text-xs text-asphalt-900 group-hover:text-ember-600 transition-colors duration-200 truncate"
            title="<?= htmlspecialchars($m->road_name ?: $m->full_name); ?>">
            <?= htmlspecialchars($m->road_name ?: $m->full_name); ?>
          </p>
          <?php if (!empty($m->position)): ?>
            <p class="text-[9px] text-asphalt-700/60 uppercase font-semibold tracking-wider mt-0.5 truncate"
              title="<?= htmlspecialchars($m->position); ?>">
              <?= htmlspecialchars($m->position); ?>
            </p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>