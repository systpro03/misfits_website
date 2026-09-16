<!-- Hero Banner Section -->
<section class="bg-asphalt-950 text-white border-b border-asphalt-800/20 py-12 md:py-16 relative overflow-hidden">
  <!-- Subtle accent glow background -->
  <div class="absolute -top-24 right-0 w-96 h-96 bg-ember-500/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="max-w-6xl mx-auto px-5 relative z-10">
    <p class="font-display text-ember-500 tracking-[0.25em] text-xs font-semibold uppercase mb-2">The Roster</p>
    <h1 class="font-display font-bold text-3xl md:text-4xl text-white tracking-tight">Meet The Team</h1>
    <p class="text-asphalt-300 text-sm mt-1 max-w-xl">
      The riders, leaders, and enthusiasts keeping the engine running.
    </p>
  </div>
</section>

<!-- Members Roster Section -->
<section class="max-w-6xl mx-auto px-5 py-12">
  <?php if (empty($members)): ?>
    <div class="bg-white border border-asphalt-800/10 rounded-2xl p-12 text-center shadow-xs max-w-md mx-auto">
      <svg class="w-12 h-12 text-asphalt-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <h3 class="font-display font-semibold text-base text-asphalt-900">Roster Coming Soon</h3>
      <p class="text-asphalt-700/60 text-xs mt-1">Our team members will be listed here shortly.</p>
    </div>
  <?php else: ?>
    <!-- Responsive roster: 2 cards per row on phones, expanding on larger screens. -->
    <div class="members-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
      <?php foreach ($members as $m): ?>
        <div
          class="group bg-white border border-asphalt-800/10 rounded-xl overflow-hidden hover:border-ember-500/50 hover:shadow-md transition-all duration-300 flex flex-col">

          <!-- Member Avatar Frame -->
          <div class="h-48 bg-asphalt-100 overflow-hidden relative">
            <img src="<?= upload_url('members', $m->image); ?>" alt="<?= htmlspecialchars($m->full_name); ?>"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

            <!-- Fallback SVG when image is missing/broken -->
            <div class="hidden absolute inset-0 flex items-center justify-center bg-asphalt-100 text-asphalt-400">
              <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>

            <!-- Position Badge (Light Color Theme) -->
            <?php if (!empty($m->position)): ?>
              <div class="absolute top-2.5 left-2.5 z-10">
                <span
                  class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold tracking-wider uppercase bg-ember-50 text-ember-700 border border-ember-200/80 shadow-xs backdrop-blur-xs">
                  <?= htmlspecialchars($m->position); ?>
                </span>
              </div>
            <?php endif; ?>
          </div>

          <!-- Member Details -->
          <div class="p-3.5 flex-1 flex flex-col justify-between">
            <div>
              <h3 class="font-display text-base font-bold text-asphalt-900 leading-tight truncate"
                title="<?= htmlspecialchars($m->road_name ?: $m->full_name); ?>">
                <?= htmlspecialchars($m->road_name ?: $m->full_name); ?>
              </h3>

              <?php if (!empty($m->road_name)): ?>
                <p class="text-[11px] text-asphalt-500 font-medium truncate mt-0.5"><?= htmlspecialchars($m->full_name); ?>
                </p>
              <?php endif; ?>

              <?php if (!empty($m->bike_model)): ?>
                <div
                  class="inline-flex items-center gap-1 mt-2 px-2 py-0.5 rounded bg-asphalt-50 text-asphalt-700 text-[11px] font-medium border border-asphalt-200/60 max-w-full truncate">
                  <svg class="w-3 h-3 text-ember-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                  <span class="truncate"><strong
                      class="font-semibold text-asphalt-900"><?= htmlspecialchars($m->bike_model); ?></strong></span>
                </div>
              <?php endif; ?>

              <?php if (!empty($m->bio)): ?>
                <p class="text-[11px] text-asphalt-600 leading-snug mt-2 line-clamp-2">
                  <?= htmlspecialchars($m->bio); ?>
                </p>
              <?php endif; ?>
            </div>

            <?php if (!empty($m->instagram_handle)): ?>
              <?php $handle = ltrim($m->instagram_handle, '@'); ?>
              <div class="pt-2.5 mt-2.5 border-t border-asphalt-800/10 flex items-center justify-between">
                <a href="https://instagram.com/<?= htmlspecialchars($handle); ?>" target="_blank" rel="noopener noreferrer"
                  class="inline-flex items-center gap-1 text-[11px] font-semibold text-ember-600 hover:text-ember-500 transition-colors truncate">
                  <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                  </svg>
                  <span class="truncate">@<?= htmlspecialchars($handle); ?></span>
                </a>
              </div>
            <?php endif; ?>

          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>