<!-- Hero Banner Section -->
<section class="bg-asphalt-950 text-white border-b border-asphalt-800/20 py-4 md:py-6 relative overflow-hidden">
  <div class="max-w-6xl mx-auto px-3 relative z-10">
    <p class="font-display text-ember-500 tracking-wider text-[9px] font-semibold uppercase mb-0.5">The Logbook</p>
    <h1 class="font-display font-semibold text-xl md:text-2xl text-white tracking-tight leading-tight">Group Rides</h1>
    <p class="text-asphalt-300 text-xs mt-0.5 max-w-xl">Join us on the open road. Browse upcoming scheduled runs and
      view past ride logs.</p>
  </div>
</section>

<!-- Content Section -->
<section class="max-w-6xl mx-auto px-3 py-4 md:py-6 space-y-6 md:space-y-8">

  <!-- ===== UPCOMING RIDES ===== -->
  <div>
    <div class="flex items-center justify-between mb-3 pb-1.5 border-b border-asphalt-800/10">
      <div class="flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-ember-500 animate-pulse"></span>
        <h2 class="font-display text-base font-semibold text-asphalt-900">Upcoming Rides</h2>
      </div>
      <a href="<?= site_url('rides/upcoming'); ?>"
        class="inline-flex items-center gap-1 text-[10px] font-display font-semibold tracking-wider uppercase text-ember-600 hover:text-ember-700 transition-colors">
        <span>View all</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </a>
    </div>

    <?php if (empty($upcoming_rides)): ?>
      <div class="bg-white border border-asphalt-800/10 rounded-lg p-4 text-center shadow-2xs">
        <p class="font-display font-medium text-asphalt-900 text-xs">No rides scheduled yet</p>
        <p class="text-asphalt-700/60 text-[10px] mt-0.5">Check back soon for upcoming group runs.</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-2.5 sm:gap-3">
        <?php foreach ($upcoming_rides as $ride): ?>
          <a href="<?= site_url('rides/' . $ride->id); ?>"
            class="group relative bg-asphalt-950 text-white rounded-md overflow-hidden border border-asphalt-800/60 hover:border-ember-500/80 shadow-2xs hover:shadow-xs transition-all duration-200 flex flex-col justify-between">

            <div class="p-3">
              <!-- Date & Badge -->
              <div class="flex items-center justify-between mb-1.5">
                <p class="font-display text-ember-400 text-[9px] font-semibold tracking-wider uppercase">
                  <?= strtoupper(date('D, M j, Y', strtotime($ride->ride_date))); ?>
                </p>
                <?php if (!empty($ride->ride_type)): ?>
                  <span
                    class="text-[9px] uppercase font-semibold px-1.5 py-0.2 rounded bg-asphalt-900 border border-asphalt-800 text-asphalt-300">
                    <?= htmlspecialchars($ride->ride_type); ?>
                  </span>
                <?php endif; ?>
              </div>

              <!-- Title -->
              <h3
                class="font-display text-sm font-semibold text-white group-hover:text-ember-400 transition-colors leading-snug mb-1 line-clamp-1">
                <?= htmlspecialchars($ride->title); ?>
              </h3>

              <!-- Description -->
              <?php if (!empty($ride->description)): ?>
                <p class="text-[11px] text-asphalt-300 leading-snug line-clamp-2">
                  <?= htmlspecialchars(mb_strimwidth(strip_tags($ride->description), 0, 90, '...')); ?>
                </p>
              <?php endif; ?>
            </div>

            <!-- Footer Meta -->
            <div
              class="px-3 py-2 bg-asphalt-900/80 border-t border-asphalt-800/40 flex items-center justify-between text-[10px] text-asphalt-400">
              <div class="inline-flex items-center gap-1 truncate">
                <svg class="w-3 h-3 text-ember-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span
                  class="truncate"><?= !empty($ride->meeting_point) ? htmlspecialchars($ride->meeting_point) : 'Location TBD'; ?></span>
              </div>
              <span class="font-semibold text-ember-500 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </div>

          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>


  <!-- ===== PAST RIDES LOG ===== -->
  <div>
    <div class="flex items-center justify-between mb-3 pb-1.5 border-b border-asphalt-800/10">
      <h2 class="font-display text-base font-semibold text-asphalt-900">Past Rides Log</h2>
      <a href="<?= site_url('rides/past'); ?>"
        class="inline-flex items-center gap-1 text-[10px] font-display font-semibold tracking-wider uppercase text-ember-600 hover:text-ember-700 transition-colors">
        <span>View all</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </a>
    </div>

    <?php if (empty($past_rides)): ?>
      <div class="bg-white border border-asphalt-800/10 rounded-lg p-4 text-center shadow-2xs">
        <p class="font-display font-medium text-asphalt-900 text-xs">No rides logged yet</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 sm:gap-3">
        <?php foreach ($past_rides as $ride): ?>
          <a href="<?= site_url('rides/' . $ride->id); ?>"
            class="group bg-white rounded-md overflow-hidden border border-asphalt-800/10 hover:border-ember-500/50 hover:shadow-xs transition-all duration-200 flex flex-col justify-between">

            <div>
              <!-- Cover Image Frame -->
              <div class="h-24 bg-asphalt-900 overflow-hidden relative">
                <img src="<?= upload_url('rides', $ride->cover_image); ?>" alt="<?= htmlspecialchars($ride->title); ?>"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

                <!-- Fallback Container if image missing -->
                <div class="hidden absolute inset-0 flex items-center justify-center bg-asphalt-900 text-asphalt-700">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>

              <!-- Body Details -->
              <div class="p-2.5">
                <p class="font-display text-ember-600 text-[9px] font-semibold tracking-wider uppercase mb-0.5">
                  <?= strtoupper(date('M j, Y', strtotime($ride->ride_date))); ?>
                </p>
                <h3
                  class="font-display text-sm font-semibold text-asphalt-900 group-hover:text-ember-600 transition-colors leading-snug line-clamp-1">
                  <?= htmlspecialchars($ride->title); ?>
                </h3>
              </div>
            </div>

            <!-- Footer arrow -->
            <div class="px-2.5 pb-2 pt-0 flex items-center justify-end">
              <span
                class="text-[10px] font-semibold text-asphalt-700/60 group-hover:text-ember-600 transition-colors flex items-center gap-0.5">
                Read log <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
              </span>
            </div>

          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</section>