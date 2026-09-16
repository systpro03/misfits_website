<!-- Hero Banner Section -->
<section class="bg-asphalt-950 text-white border-b border-asphalt-800/20 py-4 md:py-6 relative overflow-hidden">
  <div class="max-w-6xl mx-auto px-3 relative z-10">
    <div class="flex items-center gap-1 mb-0.5">
      <a href="<?= site_url('rides'); ?>"
        class="font-display text-ember-500 hover:text-ember-400 tracking-wider text-[9px] font-semibold uppercase transition-colors">
        The Logbook
      </a>
      <span class="text-asphalt-600 text-[10px]">&sol;</span>
      <span class="font-display text-asphalt-400 tracking-wider text-[9px] font-semibold uppercase">Filter</span>
    </div>
    <h1 class="font-display font-semibold text-xl md:text-2xl text-white tracking-tight leading-tight">
      <?= htmlspecialchars($heading); ?>
    </h1>
  </div>
</section>

<!-- Rides Grid Section -->
<section class="max-w-6xl mx-auto px-3 py-4 md:py-6">
  <?php if (empty($rides)): ?>
    <div class="bg-white border border-asphalt-800/10 rounded-lg p-4 text-center shadow-2xs">
      <h3 class="font-display font-semibold text-sm text-asphalt-900">Nothing Logged Here Yet</h3>
      <p class="text-asphalt-700/60 text-[11px] mt-0.5">Check back soon for new rides and event updates.</p>
      <div class="mt-2.5">
        <a href="<?= site_url('rides'); ?>"
          class="inline-flex items-center gap-1 text-[10px] font-display font-semibold uppercase tracking-wider text-ember-600 hover:text-ember-700 transition-colors">
          &larr; Back to all rides
        </a>
      </div>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 sm:gap-3">
      <?php foreach ($rides as $ride): ?>
        <a href="<?= site_url('rides/' . $ride->id); ?>"
          class="group bg-white rounded-md overflow-hidden border border-asphalt-800/10 hover:border-ember-500/50 hover:shadow-xs transition-all duration-200 flex flex-col justify-between">

          <div>
            <!-- Cover Image Frame -->
            <div class="h-24 bg-asphalt-900 overflow-hidden relative">
              <img src="<?= upload_url('rides', $ride->cover_image); ?>" alt="<?= htmlspecialchars($ride->title); ?>"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

              <!-- Fallback SVG when image is missing -->
              <div class="hidden absolute inset-0 flex items-center justify-center bg-asphalt-900 text-asphalt-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>

              <!-- Floating Ride Type Badge -->
              <?php if (function_exists('ride_badge')): ?>
                <div class="absolute top-1.5 left-1.5 z-10 scale-75 origin-top-left">
                  <?= ride_badge($ride->ride_type); ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Card Content -->
            <div class="p-2.5">
              <p class="font-display text-ember-600 text-[9px] font-semibold tracking-wider uppercase mb-0.5">
                <?= strtoupper(date('D, M j, Y', strtotime($ride->ride_date))); ?>
              </p>

              <h3
                class="font-display text-sm font-semibold text-asphalt-900 group-hover:text-ember-600 transition-colors leading-snug line-clamp-1">
                <?= htmlspecialchars($ride->title); ?>
              </h3>

              <?php if (!empty($ride->meeting_point)): ?>
                <div class="inline-flex items-center gap-1 mt-1 text-[10px] text-asphalt-700/70">
                  <svg class="w-2.5 h-2.5 text-ember-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span class="truncate">Meet at <strong
                      class="font-medium text-asphalt-800"><?= htmlspecialchars($ride->meeting_point); ?></strong></span>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Footer Action -->
          <div class="px-2.5 pb-2 pt-0 flex items-center justify-end">
            <span
              class="text-[10px] font-semibold text-asphalt-700/60 group-hover:text-ember-600 transition-colors flex items-center gap-0.5">
              View details <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </span>
          </div>

        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>